<?php 

namespace App\Repositories\Contract;

interface CityInterface
{
    public function index();

    public function getById($id);

    public function getProvince($id);

    public function getOrder($id = null);
}