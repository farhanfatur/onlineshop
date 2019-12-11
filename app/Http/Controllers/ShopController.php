<?php

namespace App\Http\Controllers;

use App\Model\Order;
use App\Model\Bank;
use App\Model\Product;
use App\Repositories\Contract\CartInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ShopController extends Controller
{
    private $cart;

    public function __construct(CartInterface $cart)
    {
        $this->cart = $cart;
    }

    public function storeCart(Request $request)
    {
        $store = $this->cart->store($request);
        return redirect()->route('indexShop')->with($store);
        
    }

    public function indexCart(Request $request)
    {
    	$cart = $this->cart->index($request);
        return view('buyer.cart.cart', $cart);
       
    }

    public function editCapacityCart($id)
    {
    	return view('buyer.cart.edit-capacity-cart', ['id' => $id]);
    }


    public function deleteCapacityCart(Request $request, $id)
    {
        $this->cart->deleteCartProduct($request, $id);

    	return redirect()->route('indexCart');
    }

    public function storeOrderCart(Request $request)
    {
        if($request->session()->get('cart') != [] || $request->session()->get('cart') != null) {
            
                $order = $this->cart->storeOrder($request);
                return redirect()->route('detailOrder', $order->id);
        }else {
            return redirect()->back()->withErrors(['Order can\'t empty !!!']);
        }
    }

    public function editQuantity(Request $request)
    {
        $carts = $this->cart->updateQuantity($request);
        return response()->json($carts);
    }
}
