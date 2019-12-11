<?php 

namespace App\Repositories\Contract;

interface CartInterface
{
	public function store($request);

	public function index($request);

	public function updateQuantity($request);

	public function deleteCartProduct($request, $id);

	public function storeOrder($request);
}