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
        if($request->capacity == null) {
            return redirect()->back()->with(['stockTooMuch' => 'Cart can\'t not empty']);
        }else {
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
                    $product = Product::find($request->id);
                    $product->quantity = $product->quantity - $request->capacity;
                    $product->save();
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
                      $product = Product::find($request->id);
                      $product->quantity = $product->quantity - $request->capacity;
                      $product->save();
                    }else {
                        return redirect()->route('indexShop')->with('sessionExist', 'You was add this product before');
                    }
                }
            }

            return redirect()->route('indexShop')->with(['messageCart' => $product->name." is store to cart with ".$request->capacity." items"]);
        }
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
        $product = Product::find($cart['id']);
        $product->quantity += intval($cart['capacity']);
        $product->save();
        
    	$request->session()->forget('cart.'.$id);

    	return redirect()->route('indexCart');
    }

    public function storeOrderCart(Request $request)
    {
        if($request->session()->get('cart') != [] || $request->session()->get('cart') != null) {
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
            foreach($carts as $cart) {
                $order->orderitem()->create([
                    'order_id' => $order->id,
                    'product_id' => $cart['id'],
                    'quantity' => $cart['capacity'],
                    'price' => $cart['price'] * $cart['capacity'],
                    'bank_id' => $request->bank_id,
                ]);
            }
            $request->session()->forget('cart');
            return redirect()->route('indexShop');
        }else {
            return redirect()->back()->withErrors(['Order is not empty']);
        }
    }

    public function editQuantity(Request $request)
    {
        $carts = $request->session()->get('cart');
        $product = Product::find($request->id);
        $id = array_search($request->id, array_column($carts, 'id'));
        if(intval($request->quantity) > $product->quantity) {
            return response()->json(["error" => "Quantity is too much", "quantity" => $carts[$id]['capacity']]);
        }else {
            $carts[$id]['capacity'] = $request->quantity;
            $carts[$id]['total_price'] = $carts[$id]['price'] * $request->quantity;
            Session::put('cart', $carts);
        }
        return response()->json($carts);
    }
}
