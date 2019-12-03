<?php

namespace App\Http\Controllers;

use App\Model\Order;
use App\Model\Bank;
use App\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
class ShopController extends Controller
{
    public function storeCart(Request $request)
    {
    	$product = Product::find($request->id);
    	if($request->capacity > $product->quantity) {
    		return redirect()->back()->with(['stockTooMuch' => 'your request is too much']);
    	}else {
    		if($request->session()->get('cart') == null) {
		    	$request->session()->push('cart', [
		    		'id' => $request->id,
		    		'name' => $product->name,
		    		'capacity' => $request->capacity,
		    		'price' => $product->price,
		    		'total_price' => $product->price * $request->capacity,
		    	]);
		    }else {
		    	$carts = $request->session()->get('cart');
		        if(!in_array($request->id, array_column($carts, 'id'))) {
		          $request->session()->push('cart', [
			    		'id' => $request->id,
			    		'name' => $product->name,
			    		'capacity' => $request->capacity,
			    		'price' => $product->price,
			    		'total_price' => $product->price * $request->capacity,
			    	]);
		        }else {
		        	return redirect()->route('indexShop')->with('sessionExist', 'You was add this product before');
		        }
		    }
    	}

    	return redirect()->route('indexShop')->with(['messageCart' => $product->name." is store to cart"]);
    }

    public function indexCart(Request $request)
    {
    	$product = $request->session()->get('cart');
        if($product) {
            $bank = Bank::all();
            return view('buyer.cart.cart', ['product' => $product, 'bank' =>$bank]);
        }else {
            return redirect()->route('indexShop')->with(['warning' => 'Add a product to store first!']);
        }
    }

    public function editCapacityCart(Request $request, $id)
    {
    	return view('buyer.cart.edit-capacity-cart', ['id' => $id]);
    }

    public function updateQuantityCart(Request $request)
    {
    	$carts = $request->session()->get('cart');
        $product = Product::find($request->id);
        if(intval($request->capacity) > $product->quantity) {
            return redirect()->back()->withErrors('Quantity is too much');
        }else {
            if(in_array($request->id, array_column($carts, 'id'))) {
                $id = array_search($request->id, array_column($carts, 'id'));
                $carts[$id]['capacity'] = $request->capacity;
                $carts[$id]['total_price'] = $carts[$id]['price'] * $request->capacity;
            }
            Session::put('cart', $carts);
        }
    	return redirect()->route('indexCart');
    }

    public function deleteCapacityCart(Request $request, $id)
    {
    	$carts = $request->session()->get('cart');
        if(count($carts) <= 1){
            foreach($carts as $i => $data) {
                $id = $i;
            }
        }else {
            $id = array_search($request->id, array_column($carts, 'id'));
        }
    	$request->session()->forget('cart.'.$id);

    	return redirect()->route('indexCart');
    }

    public function storeOrderCart(Request $request)
    {
    	$now = date('Y-m-d');
    	$start_date = strtotime($now);
    	$end_date = strtotime("+ 5 day", $start_date);
    	$carts = $request->session()->get('cart');
        $order = auth()->guard('buyer')->user()->order()->create([
                'dateorder' => $now,
                'is_receive' => '0',
                'code' => 'TK'.rand(1, 5),
                'is_paymentreceive' => '0',
                'is_paymentfrombuyer' => '0',
                'is_shipped' => '0',
                'is_cancel' => '0',
                'address' => $request->address,
                'cancelfrombuyer' => null,
                'total_price' => $request->total_price,
                'dateshipped' => date('Y-m-d', $end_date),
                'imagepayment' => null,
            ]);
    	foreach($carts as $cart) {
            $order->orderitem()->create([
                'order_id' => $order->id,
                'product_id' => $cart['id'],
                'quantity' => $cart['capacity'],
                'price' => $cart['price'],
                'bank_id' => $request->bank_id,
            ]);
            $product = Product::find($cart['id']);
            $product->quantity = $product->quantity - $cart['capacity'];
            $product->save();
    	}
    	$request->session()->forget('cart');
    	return redirect()->route('indexShop');
    }
}
