<?php

namespace App\Http\Controllers\buyer;

use App\Model\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
class OrderController extends Controller
{
    public function index()
    {
    	$order = auth()->guard('buyer')->user()->order;
    	return view('buyer.order.order', ['order' => $order]);
    }

    public function storeImagePayment(Request $request)
    {
    	$order = Order::findOrFail($request->id);
    	$namefile = $order->id."-".$order->buyer->name."-".$order->product->name.".png";
    	Storage::putFileAs('public/buyer/', $request->file('imagepayment'), $namefile);
    	$order->imagepayment = $namefile;
        $order->is_paymentfrombuyer = '1';
    	$order->save();

    	return redirect()->route('indexOrderBuyer');
    }
    
    public function indexImagePayment($id)
    {
    	return view('buyer.order.imagepayment-order', ['id' => $id]);
    }

    public function isShippedActive($id)
    {
        $order = Order::findOrFail($id);
        $order->is_shipped = '1';
        $order->save();
        
        $product = $order->product;
        if($product->is_receive == '1' && $product->is_paymentreceive == '1' && $product->ispaymentfrombuyer == '1' && $product->is_cancel == '0') {
            $product->capacity = $product->capacity - $order->capacity;
            $product->save();
        }else {
            $product->capacity = $product->capacity + $order->capacity;
            $product->save();
        }

        return redirect()->route('indexOrderBuyer');
    }

    public function isShippedDeactive($id)
    {
        $order = Order::findOrFail($id);
        $order->is_shipped = '0';
        $order->save();

        return redirect()->route('indexOrderBuyer');
    }

    public function isCancel($id)
    {
        $order = Order::findOrFail($id);
        $order->is_cancel = '1';
        $order->cancelfrombuyer = '1';
        $order->save();

        return redirect()->route('indexOrderBuyer');
    }

    public function isCancelReturn($id)
    {
        $order = Order::findOrFail($id);
        $order->is_cancel = '0';
        $order->cancelfrombuyer = '1';
        $order->save();

        return redirect()->route('indexOrderBuyer');
    }
}
