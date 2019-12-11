<?php

namespace App\Http\Controllers\seller;


use App\Model\Seller;
use Illuminate\Support\Facades\Hash;
use App\Notifications\SellerNotification;
use Illuminate\Http\Request;
use App\Mail\SendSellerEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    public function login(Request $request)
    {
    	if(auth()->guard('seller')->attempt(['email' => $request->email, 'password' => $request->password])) {

    		if(auth()->guard('seller')->user()->email_verified_at == null && auth()->guard('seller')->user()->type_seller == 'admin') {
    			
    			return redirect()->back()->withErrors(['Account is not active, please do it first']);	
    			Auth::guard('seller')->logout();
    		}else {
    			return redirect('/');
    		}
    	}else {
    		return redirect()->back()->withErrors(['Username or Password is not correct']);
    	}
    }

    public function verify($id, $name)
   	{

   		$seller = Seller::find($id)->where('name', $name);
   		if($seller) {

   			$seller->update([
   				'email_verified_at' => now(),
   			]);
   			return redirect('/seller/login')->with(['success' => 'email is verify, now you can login']);
   		}else {
   			return redirect('/seller/login')->withErrors(['ID or name is not found, please call the admin']);
   		}
   	}

}
