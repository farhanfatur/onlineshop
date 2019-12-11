<?php 

namespace App\Repositories;

use App\Model\Bank;
use App\Repositories\Contract\BankInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BankRepositories implements BankInterface
{
	use AuthorizesRequests;

	private $model;

	public function __construct(Bank $bank)
	{
		$this->model = $bank;
	}

	public function index()
	{
		$bank = $this->model::all();
		return $bank;
	}

	public function store($request)
	{
		auth()->guard('seller')->user()->bank()->create([
    		'name' => $request->name,
    		'rekening' => $request->rekening,
			'holder' => $request->holder,
    	]);
	}

	public function edit($id)
	{
		$bank = Bank::find($id);
		return $bank;
	}

	public function update($request)
	{
		Bank::find($request->id)->update([
    		'name' => $request->name,
    		'rekening' => $request->rekening,
			'holder' => $request->holder,
    	]);
	}

	public function delete($id)
	{
		Bank::find($id)->delete();
	}
}