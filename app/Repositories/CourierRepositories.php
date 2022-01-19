<?php 

namespace App\Repositories;

use App\Model\Courier;
use App\Repositories\Contract\CourierInterface;
use GuzzleHttp\Client;

class CourierRepositories implements CourierInterface
{
    private $model;

    public function __construct(Courier $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        return $this->model::all();
    }

    public function find($id)
    {
        return $this->model->where('id', $id)->first();
    }

    public function getOngkir($destination, $weight, $courier)
    {
        $seller = auth()->guard("seller");
        $client = new Client();

        $ongkir = $client->request("POST", "https://api.rajaongkir.com/starter/cost", [
            "headers" => [
                "key" => config("rajaongkir.key"),
                "Content-Type" => "application/x-www-form-urlencoded"
            ],
            "form_params" => [
                "origin" => $seller->city_id,
                "destination" => $destination,
                "weight" => $weight,
                "courier" => $courier
            ]
        ]);
        $res = json_decode($ongkir->getBody()->__toString());
        
        return json_decode($res);
    }
}