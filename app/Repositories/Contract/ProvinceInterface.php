<?php 

namespace App\Repositories\Contract;

interface ProvinceInterface
{
    public function index();

    public function getById($id);

    public function getCity($id);

    public function getOrder($id = null);
}