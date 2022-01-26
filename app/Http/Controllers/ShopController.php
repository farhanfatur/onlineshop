<?php

namespace App\Http\Controllers;

use App\Model\Order;
use App\Model\Bank;
use App\Model\Product;
use App\Repositories\Contract\BankInterface;
use App\Repositories\Contract\CartInterface;
use App\Repositories\Contract\ProvinceInterface;
use App\Repositories\Contract\CityInterface;
use App\Repositories\Contract\CourierInterface;
use App\Repositories\Contract\ProductInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ShopController extends Controller
{
    private $cart, $bank, $province, $city, $courier, $product;

    public function __construct(CartInterface $cart, 
                    BankInterface $bank, 
                    ProvinceInterface $province,
                    CityInterface $city,
                    CourierInterface $courier,
                    ProductInterface $product)
    {
        $this->cart = $cart;
        $this->bank = $bank;
        $this->province = $province;
        $this->city = $city;
        $this->courier = $courier;
        $this->product = $product;
    }

    public function storeCart(Request $request)
    {
        $store = $this->cart->store($request);
        return redirect()->route('indexShop')->with($store);
        
    }

    public function indexCart(Request $request)
    {
    	$cart = $this->cart->index($request);
        $province = $this->province->index();
        $bank = $this->bank->index();
        $courier = $this->courier->index();
        // $city = $this->city->index();
        return view('buyer.cart.cart', [
            'product' => $cart, 
            'bank' => $bank, 
            'province' => $province, 
            'courier' => $courier
            // 'city' => $city
        ]);
    }

    public function getProvinceCart($id)
    {
        $city = $this->city->getProvince($id);
        
        return $city;
    }

    public function editCapacityCart($id)
    {
    	return view('buyer.cart.edit-capacity-cart', ['id' => $id]);
    }

    public function getOngkir(Request $request)
    {
        $findId = $this->courier->find($request->courier);
        $weight = 0;
        $carts = $request->session()->get('cart');
        $sellerProduct = $this->product->getCart($carts);
        $ongkir = $this->courier->getOngkir($request->destination, strtolower($findId->name), $sellerProduct);

        return response()->json($ongkir);
    }

    public function deleteCapacityCart(Request $request, $id)
    {
        $this->cart->deleteCartProduct($request, $id);

    	return redirect()->route('indexCart');
    }

    public function storeOrderCart(Request $request)
    {
        if($request->session()->get('cart') != [] || $request->session()->get('cart') != null) {
            
                $order = $this->cart->storeOrder($request);
                return redirect()->route('detailOrder', $order->id);
        }else {
            return redirect()->back()->withErrors(['Order can\'t empty !!!']);
        }
    }

    public function editQuantity(Request $request)
    {
        $carts = $this->cart->updateQuantity($request);
        return response()->json($carts);
    }
}
