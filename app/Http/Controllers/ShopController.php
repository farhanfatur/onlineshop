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
    	if($request->capacity > $product->capacity) {
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

    	return redirect()->route('indexShop');
    }

    public function indexCart(Request $request)
    {
    	$product = $request->session()->get('cart');
    	$bank = Bank::all();
    	return view('buyer.cart.cart', ['product' => $product, 'bank' =>$bank]);
    }

    public function editCapacityCart(Request $request, $id)
    {
    	return view('buyer.cart.edit-capacity-cart', ['id' => $id]);
    }

    public function updateCapacityCart(Request $request)
    {
    	$carts = $request->session()->get('cart');
    	if(in_array($request->id, array_column($carts, 'id'))) {
    		$id = array_search($request->id, array_column($carts, 'id'));
    		$carts[$id]['capacity'] = $request->capacity;
    		$carts[$id]['total_price'] = $carts[$id]['price'] * $request->capacity;
    	}
    	Session::put('cart', $carts);
    	return redirect()->route('indexCart');
    	// dd($request->input());
    }

    public function deleteCapacityCart(Request $request, $id)
    {
    	$carts = $request->session()->get('cart');
    	$id = array_search($request->id, array_column($carts, 'id'));
    	$request->session()->forget('cart.'.$id);

    	return redirect()->route('indexCart');
    }

    public function storeOrderCart(Request $request)
    {
    	$now = date('Y-m-d');
    	$start_date = strtotime($now);
    	$end_date = strtotime("+ 5 day", $start_date);
    	$carts = $request->session()->get('cart');
    	foreach($carts as $cart) {
    		auth()->guard('buyer')->user()->order()->create([
	    		'dateorder' => $now,
	    		'is_receive' => '0',
	    		'is_paymentreceive' => '0',
	    		'is_paymentfrombuyer' => '0',
	    		'is_shipped' => '0',
	    		'is_cancel' => '0',
	    		'product_id' => $cart['id'],
	    		'bank_id' => $request->bank_id,
	    		'address' => $request->address,
	    		'cancelfrombuyer' => null,
                'capacity' => $cart->capacity,
	    		'total_price' => $request->total_price,
	    		'dateshipped' => date('Y-m-d', $end_date),
	    		'imagepayment' => null,
	    	]);
    	}
    	$request->session()->forget('cart');
    	return redirect()->route('indexShop');
    }
}
