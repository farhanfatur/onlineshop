<?php

namespace App\Http\Controllers;

use App\Model\Product;
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
        $product = Product::where('is_delete', '0')->where('is_sold', '1')->get();
        return view('welcome', ['product' => $product]);
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

    public function logoutBuyer()
    {
        Auth::guard('buyer')->logout();
        return redirect()->route('indexShop');
    }
}
