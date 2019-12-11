<?php

namespace App\Http\Controllers\seller;

use App\Repositories\Contract\StaffInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StaffController extends Controller
{
    private $model;

    public function __construct(StaffInterface $staff)
    {
        $this->model = $staff;
    }

	public function index()
	{
		$staff = $this->model->index();
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

    	$seller = $this->model->store($request);

    	if($seller) {
    		return redirect()->route('indexStaff');
    	}
    }

    public function edit($id)
    {
    	$staff = $this->model->edit($id);
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
    	$seller = $this->model->update($request);

    	if($seller) {
    		return redirect()->route('indexStaff');
    	}
    }

    public function delete($id)
    {
    	$this->model->delete($id);
    	return redirect()->route('indexStaff');
    }
}
