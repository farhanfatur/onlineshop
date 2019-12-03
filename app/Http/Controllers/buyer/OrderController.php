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
        if($order->imagepayment == null){
            $namefile = $order->id."-".$order->buyer->name."-".$order->code.".png";
            Storage::putFileAs('public/buyer/', $request->file('imagepayment'), $namefile);
            $order->imagepayment = $namefile;
            $order->is_paymentfrombuyer = '1';
            $order->save();    
        }else {
            $pathImage = storage_path('app\\public\\order\\'.$order->image);
            if(File::exists($pathImage)) {
                File::delete($pathImage);
            }
            Storage::putFileAs('public/buyer/', $request->file('imagepayment'), $namefile);
            $order->imagepayment = $namefile;
            $order->is_paymentfrombuyer = '1';
            $order->save();
        }
    	

    	return redirect()->route('indexOrderBuyer');
    }
    
    public function indexImagePayment($id)
    {
        $order = Order::find($id);
    	return view('buyer.order.imagepayment-order', ['id' => $id, 'order' => $order]);
    }

    public function isShippedActive($id)
    {
        $order = Order::findOrFail($id);
        $now = date('Y-m-d');
        if($now >= $order->dateshipped) {
            $order->is_shipped = '1';
            $order->save();
        }else {
            return redirect()->route('indexOrderBuyer')->with(['dateError' => 'Product is not shipped this day']);
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
