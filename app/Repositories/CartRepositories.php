<?php 

namespace App\Repositories;

use App\Model\Product;
use App\Model\Bank;
use Illuminate\Support\Facades\Session;
use App\Repositories\Contract\CartInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CartRepositories implements CartInterface
{
	use AuthorizesRequests;

	protected $product;
	protected $bank;

	public function __construct(Product $product, Bank $bank)
	{
		$this->product = $product;
		$this->bank = $bank;
	}

	public function index($request)
	{
		$product = $request->session()->get('cart');
        $bank = $this->bank::all();

        return ['product' => $product, 'bank' => $bank];
	}

	public function store($request)
	{
		$product = $this->product::find($request->id);
        $carts = $request->session()->get('cart');
        if($carts == null || !in_array($request->id, array_column($carts, 'id'))) {
          $request->session()->push('cart', [
                'id' => $request->id,
                'name' => $product->name,
                'capacity' => 1,
                'price' => $product->price,
                'total_price' => $product->price * 1,
            ]);
          $product = $this->product::find($request->id);
          $product->quantity = $product->quantity - 1;
          $product->save();
        }else {
            return ["sessionExist" => "You was store this ".$product->name." before!!"];
        }
        
        return ['messageCart' => $product->name." is store to cart with 1 items"];
	}

	public function updateQuantity($request)
	{
		$carts = $request->session()->get('cart');
        $product = $this->product::find($request->id);
        $id = array_search($request->id, array_column($carts, 'id'));
        if(intval($request->quantity) > $product->quantity) {
            return response()->json(["error" => "Quantity is too much", "quantity" => $carts[$id]['capacity']]);
        }else {
            $carts[$id]['capacity'] = $request->quantity;
            $carts[$id]['total_price'] = $carts[$id]['price'] * $request->quantity;
            Session::put('cart', $carts);
            if($request->quantity == 0) {
            	$product->quantity = $product->quantity - 0;
            }else {
            	$product->quantity = $product->quantity + 1 - $request->quantity;	
            }
            
        	$product->save();
        }

        return $carts;
	}

	public function storeOrder($request)
	{
		$now = date('Y-m-d');
        $carts = $request->session()->get('cart');
        $order = auth()->guard('buyer')->user()->order()->create([
            'dateorder' => $now,
            'code' => 'TK'.rand(100, 999),
            'status_id' => 1,
            'address' => $request->address,
            'total_price' => $request->total_price,
            'datereceive' => null,
            'imagepayment' => null,
        ]);
        foreach($request->check as $i => $check) {
            $id = array_search($i, array_column($carts, 'id'));
            $order->orderitem()->create([
                'order_id' => $order->id,
                'product_id' => $carts[$id]['id'],
                'quantity' => $carts[$id]['capacity'],
                'price' => $carts[$id]['price'] * $carts[$id]['capacity'],
                'bank_id' => $request->bank_id,
            ]);
        }
        $request->session()->forget('cart');

        return $order;
	}

	public function deleteCartProduct($request, $id)
	{
		$id;
    	$carts = $request->session()->get('cart');
        if(count($carts) <= 1){
            foreach($carts as $i => $data) {
                $id = $i;
            }
        }else {
            $id = array_search($request->id, array_column($carts, 'id'));
        }
        $cart = $request->session()->get('cart.'.$id);
        $product = $this->product::find($cart['id']);
        $product->quantity += intval($cart['capacity']);
        $product->save();
        
    	$request->session()->forget('cart.'.$id);
	}
}