<?php

namespace App\Http\Controllers\buyer;

use App\Model\Buyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function login(Request $request)
    {
    	if(auth()->guard('buyer')->attempt(['email' => $request->email, 'password' => $request->password])){
    		return redirect()->route('indexShop'); 
    	}else {
    		return redirect()->back()->withErrors(['username or password is not correct']);
    	}
    }

    public function register(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:sellers',
            'password' => 'required|string|min:8|confirmed',
            'address' => 'required|string',
            'phone' => 'required',
            'datebirth' => 'required|date',
    	]);

    	$seller = Buyer::create([
  			'name' => $request->name,
  			'email' => $request->email,
  			'password' => Hash::make($request->password),
  			'address' => $request->address,
  			'phone' => $request->phone,
  			'datebirth' => $request->datebirth,
    	]);

    	if($seller) {
    		return redirect()->route('loginIndexBuyer')->with(['success' => 'Account is created']);
    	}
    }
}
