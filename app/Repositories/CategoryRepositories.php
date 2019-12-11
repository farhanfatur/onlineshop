<?php 

namespace App\Repositories;

use App\Model\Category;
use Illuminate\Http\Request;
use App\Repositories\Contract\CategoryInterface;

class CategoryRepositories implements CategoryInterface
{
	protected $model;

	public function __construct(Category $category)
	{
		$this->model = $category;
	}

	public function index()
	{
		$category = $this->model::all();
		return $category;
	}	

	public function store($request)
	{
		$category = $this->model::create([
			'name' => $request->name,
		]);

		return $category;
	}

	public function edit($id)
	{
		$category = $this->model::find($id);

		return $category;
	}

	public function findByParamFirst($param, $val)
	{
		$category = $this->model::where($param, $val)->first();
		return $category;
	}

	public function findByParamGet($param, $val)
	{
		$category = $this->model::where($param, $val)->get();
		return $category;
	}

	public function update($request)
	{
		$category = $this->model::find($request->id)->update([
			'name' => $request->name,
		]);

		return $category;
	}

	public function delete($id)
	{
		$category = $this->model::find($id);
		$category->delete();

		return $category;
	}
}