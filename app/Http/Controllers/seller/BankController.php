<?php

namespace App\Http\Controllers\seller;

use App\Model\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BankController extends Controller
{
    public function index()
    {
    	$bank = Bank::all();
    	return view('seller.bank.bank', ['bank' => $bank]);
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required|max:50',
    		'rekening' => 'required',
			'holder' => 'required',
    	]);

    	auth()->guard('seller')->user()->bank()->create([
    		'name' => $request->name,
    		'rekening' => $request->rekening,
			'holder' => $request->holder,
    	]);	

    	return redirect()->route('indexBank');
    }

    public function edit($id)
    {
    	$bank = Bank::find($id);
    	return view('seller.bank.edit-bank', ['bank' => $bank]);
    }

    public function update(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required|max:50',
    		'rekening' => 'required',
			'holder' => 'required',
    	]);

    	Bank::find($request->id)->update([
    		'name' => $request->name,
    		'rekening' => $request->rekening,
			'holder' => $request->holder,
    	]);

    	return redirect()->route('indexBank');
    }

    public function delete($id)
    {
    	Bank::find($id)->delete();

    	return redirect()->route('indexBank');
    }
}
