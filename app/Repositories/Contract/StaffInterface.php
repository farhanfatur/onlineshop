<?php 

namespace App\Repositories\Contract;

interface StaffInterface
{
	public function index();

	public function store($request);

	public function edit($id);

	public function update($request);

	public function delete($id);
}