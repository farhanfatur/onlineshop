<?php

namespace App\Http\Controllers\seller;

use App\Model\Category;
use App\Model\Product;
use App\Http\Controllers\Controller;
use App\Events\EventUploadImage;
use App\Repositories\Contract\ProductInterface;
use App\Repositories\Contract\CategoryInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $model;
    private $category;

    public function __construct(ProductInterface $product, CategoryInterface $category)
    {
        $this->model = $product;
        $this->category = $category;
    }

    public function index() 
    {
        $product = $this->model->index();

    	return view('seller.product.product', ['product' => $product]);
    }

    public function add()
    {
    	$category = $this->category->index();
    	return view('seller.product.add-product', ['category' => $category]);
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required|max:50',
    		'quantity' => 'required',
            'code' => 'required',
			'category' => 'required',
			'price' => 'required',
			'description' => 'required',
    	]);
        $image = "default.png";
    	if($request->image) {
            $image = $request->name.".png";
        }
    	
        $product = $this->model->store($image, $request);
    	if($product) {
            if($request->image) {
                $file = $request->file('image');
                event(new EventUploadImage($file, $image));
            }
    		return redirect()->route('indexProduct');
    	}else {
    		return redirect()->back()->withErrors('Data is credential');
    	}
    }

    public function active($id)
    {
    	$product = $this->model->active($id);
    	if($product) {
    		return redirect()->route('indexProduct');
    	}else {
    		return redirect()->back()->withErrors('ID is not found');
    	}
    }

    public function deactive($id)
    {
    	$product = $this->model->deactive($id);
    	if($product) {
    		return redirect()->route('indexProduct');
    	}else {
    		return redirect()->back()->withErrors('ID is not found');
    	}
    }

    public function edit($id)
    {
    	$product = $this->model->edit($id);
    	$category = $this->category->index();
    	return view('seller.product.edit-product', ['product' => $product, 'category' => $category]);
    }

    public function update(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required|max:50',
    		'quantity' => 'required',
			'category' => 'required',
            'code' => 'required',
			'price' => 'required',
			'description' => 'required',
    	]);

        $product = $this->model->update($request);
        if($product) {
            return redirect()->route('indexProduct');    
        }
    }

    public function delete($id)
    {
    	$this->model->delete($id);
        
    	return redirect()->route('indexProduct');
    }
}
