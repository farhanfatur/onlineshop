<?php 

namespace App\Repositories\Contract;

interface ProductInterface
{
	public function index();

	public function store($image, $request);

	public function edit($id);

	public function update($request);
	
	public function delete($id);
}