<?php

namespace App\Http\Controllers\seller;

use App\Model\Product;
use App\Model\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
    	$order = Order::all();
    	return view('seller.order.order', ['order' => $order]);
    }

    public function isReceiveActive($id)
    {
    	$order = Order::findOrFail($id);
    	$order->is_receive = '1';
    	$order->save();

    	return redirect()->route('indexOrderSeller');
    }

    public function isReceiveDeactive($id)
    {
    	$order = Order::findOrFail($id);
    	$order->is_receive = '0';
    	$order->save();

    	return redirect()->route('indexOrderSeller');
    }

    public function isPaymentReceiveActive($id)
    {
    	$order = Order::findOrFail($id);
    	$order->is_paymentreceive = '1';
    	$order->save();

    	return redirect()->route('indexOrderSeller');
    }

    public function isPaymentReceiveDeactive($id)
    {
    	$order = Order::findOrFail($id);
    	$order->is_paymentreceive = '0';
    	$order->save();

    	return redirect()->route('indexOrderSeller');
    }

    public function isCancelSellerActive($id)
    {
    	$order = Order::findOrFail($id);
    	$order->cancelfrombuyer = '0';
    	$order->is_cancel = '1';
    	$order->save();
        foreach($order->orderitem as $orderitem) {
            $product = Product::find($orderitem->product->id);
            $product->quantity = $product->quantity + $orderitem->quantity;
            $product->save();
        }
    	return redirect()->route('indexOrderSeller');
    }

    public function isCancelSellerDeactive($id)
    {
    	$order = Order::findOrFail($id);
    	$order->cancelfrombuyer = '0';
    	$order->is_cancel = '0';
    	$order->save();
        foreach($order->orderitem as $orderitem) {
            $product = Product::find($orderitem->product->id);
            $product->quantity = $product->quantity - $orderitem->quantity;
            $product->save();
        }
    	return redirect()->route('indexOrderSeller');
    }
}

