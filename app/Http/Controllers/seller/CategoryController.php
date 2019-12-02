<?php

namespace App\Http\Controllers\seller;

use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
	public function index()
	{
		$category = Category::all();
		return view('seller.category.category', ['category' => $category]);
	}


	public function edit($id)
	{
		$category = Category::find($id);
		
		return view('seller.category.edit-category', ['category' => $category]);
	}

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required|string',
    		
    	]);
    	Category::create([
    		'name' => $request->name,
    		
    	]);

    	return redirect()->route('categoryIndex');
    }

    public function update(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required|string',
    		
    	]);
    	Category::find($request->id)->update([
    		'name' => $request->name,
    		
    	]);

    	return redirect()->route('categoryIndex');
    }

    public function delete($id)
    {
    	$category = Category::find($id);
    	$category->delete();

    	return redirect()->route('categoryIndex');
    }
}
