<?php

namespace App\Http\Controllers\buyer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
    	$buyer = auth()->guard('buyer')->user();
    	return view('buyer.profile.profile', ['buyer' => $buyer]);
    }

    public function update(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'address' => 'required|string',
            'phone' => 'required',
            'datebirth' => 'required|date',
    	]);
    	if($request->password == null) {
    		auth()->guard('buyer')->user()->update([
	    		'name' => $request->name,
	  			'email' => $request->email,
	  			'address' => $request->address,
	  			'phone' => $request->phone,
	  			'datebirth' => $request->datebirth,
	    	]);
    	}else {
    		auth()->guard('buyer')->user()->update([
	    		'name' => $request->name,
	  			'email' => $request->email,
	  			'password' => Hash::make($request->password),
	  			'address' => $request->address,
	  			'phone' => $request->phone,
	  			'datebirth' => $request->datebirth,
	    	]);
    	}
    	return redirect()->route('indexProfile')->with(['success' => "Profile is updated"]);
    }
}
