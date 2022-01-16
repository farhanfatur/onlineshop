<?php 

namespace App\Repositories;

use App\Model\Product;
use App\Events\EventUploadImage;
use App\Repositories\Contract\ProductInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductRepositories implements ProductInterface
{
	use AuthorizesRequests;

	protected $product;

	public function __construct(Product $product)
	{
		$this->product = $product;
	}

	public function index()
	{
		$product = null;
        if(auth()->guard('seller')->user()->type_seller == 'admin'){
    	   $product = $this->product::where('is_delete', '0')->get();
        }else {
            $product = auth()->guard('seller')->user()->product()->where('is_delete', '0')->get();
        }
        return $product;
	}

	public function store($image, $request)
	{
    	
    	$product = auth()->guard('seller')->user()->product()->create([
    		'name' => $request->name,
            'code' => $request->code.rand(100, 999),
    		'name_slug' => strtolower(str_slug($request->name)),
			'quantity' => $request->quantity,
			'category_id' => $request->category,
			'price' => $request->price,
			'description' => $request->description,
			'image' => $image,
			'is_sold' => '0',
			'is_delete' => '0',
    	]);

    	return $product;
	}

	public function showProduct($isDelete = 0, $isSold = 0, $paginate = 3)
	{
		$product = Product::where('is_delete', $isDelete)->where('is_sold', $isSold)->paginate($paginate);
		return $product;
	}

	public function showByParam($param, $val, $operator = "=", $paginate = 3)
	{
		$product = Product::where($param, $operator, $val)->where('is_delete', '0')->paginate($paginate);
		return $product;
	}

	public function active($id)
	{
		$product = Product::find($id)->update([
    		'is_sold' => '1',
    	]);

    	return $product;
	}

	public function deactive($id)
	{
		$product = Product::find($id)->update([
    		'is_sold' => '0',
    	]);

		return $product;
	}

	public function edit($id)
	{
		$product = $this->product::find($id);
		return $product;
	}

	public function update($request)
	{
		$product = $this->product::find($request->id);
        $image = $request->name.".png";
    	if($request->image) {
            $file = $request->file('image');

      		$image = $request->name.".png";
            event(new EventUploadImage($file, $image));

            $product->name = $request->name;
    		$product->name_slug = strtolower(str_slug($request->name));
            if($request->code != $product->code) {
                $product->code = $request->code.rand(100, 999);
            }
			$product->quantity = $request->quantity;
			$product->category_id = $request->category;
			$product->price = $request->price;
            $product->image = $image;
			$product->description = $request->description;
			$product->save();

			

    	}else {
    		$product->name = $request->name;
    		$product->name_slug = strtolower(str_slug($request->name));
            if($request->code != $product->code) {
                $product->code = $request->code.rand(100, 999);
            }
			$product->quantity = $request->quantity;
			$product->category_id = $request->category;
			$product->price = $request->price;
			$product->description = $request->description;
			$product->save();
			
    	}

    	return $product;
	}

	public function delete($id)
	{
		$product = $this->product::find($id);
    	$product->is_delete = '1';
        $product->save();
	}
}