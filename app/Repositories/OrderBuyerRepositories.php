<?php 

namespace App\Repositories;

use App\Model\Order;
use App\Model\Product;
use App\Repositories\Contract\OrderBuyerInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderBuyerRepositories implements OrderBuyerInterface
{
	use AuthorizesRequests;

	protected $model;
	protected $product;

	public function __construct(Order $order, Product $product)
	{
		$this->model = $order;
		$this->product = $product;
	}

	public function index()
	{
		$order = auth()->guard('buyer')->user()->order;
		return $order;
	}

	public function storeImagePayment($request)
	{
		$order = $this->model::findOrFail($request->id);
        $namefile = $request->id."-".$order->buyer->name."-order".".png";
        $file = $request->file('imagepayment');
        $file->move('public/buyer/', $namefile);

        $order->imagepayment = $namefile;
        $order->status_id = 2;
        $order->save();

        return $order;
	}

	public function find($id)
	{
		$order = $this->model::find($id);
		return $order;
	}

	public function receiveActive($id)
	{
		$order = $this->model::findOrFail($id);
        $now = date('Y-m-d');

        $order->status_id = 4;
        $order->datereceive = $now;
        $order->save();
	}

	public function cancel($id)
	{
		$order = $this->model::findOrFail($id);
        $order->status_id = 5;
        $order->save();
        foreach($order->orderitem as $orderitem) {
            $product = $this->product::find($orderitem->product->id);
            $product->quantity = $product->quantity + $orderitem->quantity;
            $product->save();
        }
        return $order->id;
	}
}