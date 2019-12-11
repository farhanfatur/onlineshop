<?php 

namespace App\Repositories;

use App\Model\Seller;
use App\Repositories\Contract\StaffInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class StaffRepositories implements StaffInterface
{
	use AuthorizesRequests, ValidatesRequests;

	protected $seller;

	public function __construct(Seller $seller)
	{
		$this->seller = $seller;
	}

	public function index()
	{
		$staff = auth()->guard('seller')->user()->where('type_seller', 'staff')->get();
		return $staff;
	}

	public function store($request)
	{
		$seller = $this->seller::create([
  			'name' => $request->name,
  			'email' => $request->email,
  			'password' => Hash::make($request->password),
  			'address' => $request->address,
  			'phone' => $request->phone,
  			'datebirth' => $request->datebirth,
        	'type_seller' => 'staff',	
    	]);
    	return $seller;
	}

	public function edit($id)
	{
		$staff = $this->seller::find($id);
		return $staff;
	}

	public function update($request)
	{
		$seller;
    	if($request->password != "" || $request->confirmation_password != "") {
            $this->validate($request, [
                'password' => 'required|string|min:8|confirmed',
            ]);
    		$seller = $this->seller::find($request->id)->update([
	  			'name' => $request->name,
	  			'email' => $request->email,
	  			'password' => Hash::make($request->password),
	  			'address' => $request->address,
	  			'phone' => $request->phone,
	  			'datebirth' => $request->datebirth,
	    	]);
    	}else {
    		$seller = $this->seller::find($request->id)->update([
	  			'name' => $request->name,
	  			'email' => $request->email,
	  			'address' => $request->address,
	  			'phone' => $request->phone,
	  			'datebirth' => $request->datebirth,
	    	]);
    	}
    	return $seller;
	}

	public function delete($id)
	{
		$this->seller::find($id)->delete();
	}
}