<?php 

namespace App\Repositories\Contract;

interface OrderBuyerInterface
{
	public function index();

	public function storeImagePayment($request);

	public function find($id);

	public function receiveActive($id);

	public function cancel($id);
	
}