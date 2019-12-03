<?php

namespace App\Http\Controllers\seller;

use App\Model\Seller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StaffController extends Controller
{
	public function index()
	{
		$staff = auth()->guard('seller')->user()->where('type_seller', 'staff')->get();
		return view('seller.staff.staff', ['staff' => $staff]);
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

    	$seller = Seller::create([
  			'name' => $request->name,
  			'email' => $request->email,
  			'password' => Hash::make($request->password),
  			'address' => $request->address,
  			'phone' => $request->phone,
  			'datebirth' => $request->datebirth,
        	'type_seller' => 'staff',	
    	]);

    	if($seller) {
    		return redirect()->route('indexStaff');
    	}
    }

    public function edit($id)
    {
    	$staff = Seller::find($id);
    	return view('seller.staff.edit-staff', ['staff' => $staff]);
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
    	$seller;
    	if($request->password != "" || $request->confirmation_password != "") {
            $this->validate($request, [
                'password' => 'required|string|min:8|confirmed',
            ]);
    		$seller = Seller::find($request->id)->update([
	  			'name' => $request->name,
	  			'email' => $request->email,
	  			'password' => Hash::make($request->password),
	  			'address' => $request->address,
	  			'phone' => $request->phone,
	  			'datebirth' => $request->datebirth,
	    	]);
    	}else {
    		$seller = Seller::find($request->id)->update([
	  			'name' => $request->name,
	  			'email' => $request->email,
	  			'address' => $request->address,
	  			'phone' => $request->phone,
	  			'datebirth' => $request->datebirth,
	    	]);
    	}

    	if($seller) {
    		return redirect()->route('indexStaff');
    	}
    }

    public function delete($id)
    {
    	Seller::find($id)->delete();
    	return redirect()->route('indexStaff');
    }
}
