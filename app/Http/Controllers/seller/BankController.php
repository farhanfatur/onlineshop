<?php

namespace App\Http\Controllers\seller;

use App\Model\Bank;
use App\Repositories\Contract\BankInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BankController extends Controller
{
    private $model;

    public function __construct(BankInterface $bank)
    {
        $this->model = $bank;
    }

    public function index()
    {
    	$bank = $this->model->index();
    	return view('seller.bank.bank', ['bank' => $bank]);
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required|max:50',
    		'rekening' => 'required',
			'holder' => 'required',
    	]);

    	$this->model->store($request);

    	return redirect()->route('indexBank');
    }

    public function edit($id)
    {
    	$bank = $this->model->edit($id);
    	return view('seller.bank.edit-bank', ['bank' => $bank]);
    }

    public function update(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required|max:50',
    		'rekening' => 'required',
			'holder' => 'required',
    	]);

    	$this->model->update($request);

    	return redirect()->route('indexBank');
    }

    public function delete($id)
    {
    	$this->model->delete($id);

    	return redirect()->route('indexBank');
    }
}
