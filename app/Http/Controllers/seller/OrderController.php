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

    public function isShippedActive($id)
    {
    	$order = Order::findOrFail($id);
    	$order->status_id = 3;
    	$order->save();
    	return redirect()->route('indexOrderSeller');
    }

    public function isShippedDeactive($id)
    {
    	$order = Order::findOrFail($id);
    	$order->status_id = 2;
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
    	$order->status_id = 6;
    	$order->save();
        foreach($order->orderitem as $orderitem) {
            $product = Product::find($orderitem->product->id);
            $product->quantity += $orderitem->quantity;
            $product->save();
        }
    	return redirect()->route('indexOrderSeller');
    }

    public function isCancelSellerDeactive($id)
    {
    	$order = Order::findOrFail($id);
        if($order->imagepayment == null) {
            $order->status_id = 1;
        }else {
            $order->status_id = 2;
        }
    	$order->save();
        foreach($order->orderitem as $orderitem) {
            $product = Product::find($orderitem->product->id);
            if($product->quantity <= 0) {
                $product->quantity = 0;
            }
            $product->quantity = $product->quantity - $orderitem->quantity;
            $product->save();
        }
    	return redirect()->route('indexOrderSeller');
    }
}

