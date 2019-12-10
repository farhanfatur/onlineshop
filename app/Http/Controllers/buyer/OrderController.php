<?php

namespace App\Http\Controllers\buyer;

use App\Model\Product;
use App\Model\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
class OrderController extends Controller
{
    public function index()
    {
    	$order = auth()->guard('buyer')->user()->order;
        // dd($order);
    	return view('buyer.order.order', ['order' => $order]);
    }

    public function storeImagePayment(Request $request)
    {

    	$order = Order::findOrFail($request->id);
        $namefile = $request->id."-".$order->buyer->name."-order".".png";
        Storage::putFileAs('public/buyer/', $request->file('imagepayment'), $namefile);
        $order->imagepayment = $namefile;
        $order->status_id = 2;
        $order->save();

    	return redirect()->route('detailOrder', ['id' => $order->id]);
    }
    
    public function detailOrder($id)
    {
        $order = Order::find($id);
        return view('buyer.order.detail', ['orderitem' => $order->orderitem, 'order' => $order, 'code' => $order->code, 'total_price' => $order->total_price]);
    } 

    // public function indexImagePayment($id)
    // {
    //     $order = Order::find($id);
    // 	return view('buyer.order.imagepayment-order', ['id' => $id, 'order' => $order]);
    // }

    public function isReceiveActive($id)
    {
        $order = Order::findOrFail($id);
        $now = date('Y-m-d');

            $order->status_id = 4;
            $order->datereceive = $now;
            $order->save();

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
        $order->status_id = 5;
        $order->save();
        foreach($order->orderitem as $orderitem) {
            $product = Product::find($orderitem->product->id);
            $product->quantity = $product->quantity + $orderitem->quantity;
            $product->save();
        }
        return redirect()->route('detailOrder', ['id' => $id]);
    }

    public function isCancelReturn($id)
    {
        $order = Order::findOrFail($id);
        if($order->imagepayment != null) {
            $order->status_id = 2;
        }else {
            $order->status_id = 1;
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
        return redirect()->route('indexOrderBuyer');
    }
}
