<?php

namespace App\Http\Controllers\seller;

use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\EventUploadImage;
use App\Repositories\Contract\CategoryInterface;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    private $category;

    public function __construct(CategoryInterface $category)
    {
        $this->category = $category;
    }

	public function index()
	{
		$category = $this->category->index();

		return view('seller.category.category', ['category' => $category]);
	}


	public function edit($id)
	{
		$category = $this->category->edit($id);
		
		return view('seller.category.edit-category', ['category' => $category]);
	}

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required|string',
    	]);
    	$this->category->store($request);

    	return redirect()->route('categoryIndex');
    }

    public function update(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required|string',
    		
    	]);
    	$this->category->update($request);

    	return redirect()->route('categoryIndex');
    }

    public function delete($id)
    {
    	$this->category->delete($id);

    	return redirect()->route('categoryIndex');
    }
}
