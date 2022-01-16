<?php 

namespace App\Repositories;

use App\Model\City;
use App\Repositories\Contract\CityInterface;

class CityRepositories implements CityInterface
{
    private $model;

    public function __construct(City $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        return $this->model::all();
    }

    public function getById($id)
    {
        $city = $this->model->where('id', $id)->first();
        return $city;
    }

    public function getProvince($id)
    {
        $city = $this->model->where('province_id', $id)->get();
        return $city;
    }

    public function getOrder($id = null)
    {
        $order = $this->model->order()->where('city_id', $id)->get();
        return $order;
    }

}
