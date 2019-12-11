<?php 

namespace App\Repositories\Contract;

interface CategoryInterface
{
	public function index();

	public function store($request);

	public function edit($id);

	public function update($request);

	public function delete($id);
}