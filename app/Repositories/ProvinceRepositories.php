<?php 

namespace App\Repositories;

use App\Model\Province;
use App\Repositories\Contract\ProvinceInterface;

class ProvinceRepositories implements ProvinceInterface
{
    private $model;

    public function __construct(Province $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        return $this->model::all();
    }

    public function getById($id)
    {
        $province = $this->model::where('id', $id)->first();
        return $province;
    }

    public function getCity($id)
    {
        $province = $this->model->city()->where('province_id', $id)->get();
        return $province;
    }

    public function getOrder($id = null)
    {
        $order = $this->model->order()->get();
        if($id != null) {
            $order = $this->model->order()->where('province_id', $id)->get();
        }
        return $order;
    }
}