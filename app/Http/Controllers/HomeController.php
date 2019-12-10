<?php

namespace App\Http\Controllers;

use App\Model\Product;
use App\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        
        $product = Product::where('is_delete', '0')->where('is_sold', '1')->paginate(9);
        return view('welcome', ['product' => $product, 'category' => $this->categoryAll(), 'searchtext' => null]);
    }

    public function logoutSeller()
    {
        Auth::guard('seller')->logout();
        return redirect()->route('indexShop');
    }

    public function detailProduct($nameslug)
    {
        $product = Product::where('name_slug', $nameslug)->get();
        return view('detail', ['product' => $product]);
    }

    public function searchProduct(Request $request)
    {
        $product;
        if($request->searchtext == null) {
            $product = Product::all();
        }else {
            $product = Product::where('name', 'like', '%'.$request->searchtext.'%')->get();
        }
        return view('welcome', ['product' => $product, 'category' => $this->categoryAll(), 'searchtext' => $request->searchtext]);
    }

    public function getCategory($name)
    {
        $category = $this->categoryByName($name);
        return view('welcome', ['product' => $category->product, 'category' => $this->categoryAll(), 'searchtext' => null]);
    }

    public function logoutBuyer()
    {
        Auth::guard('buyer')->logout();
        return redirect()->route('indexShop');
    }
}
