<?php

namespace App\Http\Controllers\buyer;

use App\Model\Product;
use App\Model\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contract\OrderBuyerInterface;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{

    private $orderBuyer;

    public function __construct(OrderBuyerInterface $order)
    {
        $this->orderBuyer = $order;
    }

    public function index()
    {
    	$order = $this->orderBuyer->index();
    	return view('buyer.order.order', ['order' => $order]);
    }

    public function storeImagePayment(Request $request)
    {

    	$order = $this->orderBuyer->storeImagePayment($request);

    	return redirect()->route('detailOrder', ['id' => $order->id]);
    }
    
    public function detailOrder($id)
    {
        $order = $this->orderBuyer->find($id);
        return view('buyer.order.detail', ['orderitem' => $order->orderitem, 'order' => $order, 'code' => $order->code, 'total_price' => $order->total_price]);
    } 

    public function isReceiveActive($id)
    {
        $this->orderBuyer->receiveActive($id);

        return redirect()->route('indexOrderBuyer');
    }

  

    public function isCancel($id)
    {
        $idOrder = $this->orderBuyer->cancel($id);
        return redirect()->route('detailOrder', ['id' => $idOrder]);
    }

   
}
