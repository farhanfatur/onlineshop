<?php

namespace App\Http\Controllers;

use App\Model\Category;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function categoryAll()
    {
    	$category = Category::all();
    	return $category;
    }

    public function categoryByName($name)
    {
    	$category = Category::where('name', $name)->first();
    	return $category;
    }
}
