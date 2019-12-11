<?php

namespace App\Http\Controllers;

use App\Model\Product;
use App\Model\Category;
use App\Repositories\Contract\ProductInterface;
use App\Repositories\Contract\CategoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    private $product;
    private $category;

    public function __construct(ProductInterface $product, CategoryInterface $category)
    {
        $this->product = $product;
        $this->category = $category;
    }

    public function index(Request $request)
    {
        
        $product = $this->product->showProduct('0', '1', 6);
        return view('welcome', ['product' => $product, 'category' => $this->category->index(), 'searchtext' => null]);
    }

    public function detailProduct($nameslug)
    {
        $product = $this->product->showByParam('name_slug', $nameslug, 6);
        return view('detail', ['product' => $product]);
    }

    public function searchProduct(Request $request)
    {
        $product;
        if($request->searchtext == null) {
            $product = $this->product->showProduct('0', '1', 6);
        }else {
            $product = $this->product->showByParam('name', '%'.$request->searchtext.'%', 'like', 6);
        }
        return view('welcome', ['product' => $product, 'category' => $this->category->index(), 'searchtext' => $request->searchtext]);
    }

    public function getCategory($name)
    {
        $category = $this->category->findByParamFirst('name', $name);
        return view('welcome', ['product' => $category->product()->paginate(6), 'category' => $this->category->index(), 'searchtext' => null]);
    }

    public function logoutSeller()
    {
        Auth::guard('seller')->logout();
        return redirect()->route('indexShop');
    }

    public function logoutBuyer()
    {
        Auth::guard('buyer')->logout();
        return redirect()->route('indexShop');
    }
}
