<?php 

namespace App\Repositories\Contract;

interface CourierInterface
{
    public function index();

    public function find($id);

    public function getOngkir($destination, $weight, $courier);
}