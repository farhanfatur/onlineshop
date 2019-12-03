<?php

namespace App\Http\Controllers\seller;

use App\Model\Category;
use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index() 
    {
        $product;
        if(auth()->guard('seller')->user()->type_seller == 'admin'){
    	   $product = Product::where('is_delete', '0')->get();
        }else {
            $product = auth()->guard('seller')->user()->product()->where('is_delete', '0')->get();
        }

    	return view('seller.product.product', ['product' => $product]);
    }

    public function add()
    {
    	$category = Category::all();
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
			'image' => 'required',
    	]);
    	
    	$image = $request->name.".png";
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
    	if($product) {
    		Storage::putFileAs('public/product/', $request->file('image'), $image);	
    		return redirect()->route('indexProduct');
    	}else {
    		return redirect()->back()->withErrors('Data is credential');
    	}
    }

    public function active($id)
    {
    	$product = Product::find($id)->update([
    		'is_sold' => '1',
    	]);
    	if($product) {
    		return redirect()->route('indexProduct');
    	}else {
    		return redirect()->back()->withErrors('ID is not found');
    	}
    }

    public function deactive($id)
    {
    	$product = Product::find($id)->update([
    		'is_sold' => '0',
    	]);
    	if($product) {
    		return redirect()->route('indexProduct');
    	}else {
    		return redirect()->back()->withErrors('ID is not found');
    	}
    }

    public function edit($id)
    {
    	$product = Product::find($id);
    	$category = Category::all();
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

    	$product = Product::find($request->id);
        $image = $request->name.".png";
    	if($request->image) {
            $file = $request->file('image');

      		$image = $request->name.".png";
            $file->move(storage_path('app/public/product/'), $image);

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
        return redirect()->route('indexProduct');
    }

    public function delete($id)
    {
    	$product = Product::find($id);
    	$product->is_delete = '1';
        $product->save();
        
    	return redirect()->route('indexProduct');
    }
}
