<?php 

namespace App\Repositories;

use App\Model\Courier;
use App\Repositories\Contract\CourierInterface;
use GuzzleHttp\Client;
use PHPUnit\Framework\Constraint\IsEmpty;

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

    public function getOngkir($destination, $courier, $sellerProduct)
    {
        $seller = auth()->guard("seller");
        $client = new Client();

        $ongkirProducts = [];
        $ongkirCosts = [];
        $costs = 0;

        foreach($sellerProduct as $seller) {
            $ongkir = $client->request("POST", "https://api.rajaongkir.com/starter/cost", [
                "headers" => [
                    "key" => config("rajaongkir.key"),
                    "Content-Type" => "application/x-www-form-urlencoded"
                ],
                "form_params" => [
                    "origin" => $seller['city'],
                    "destination" => $destination,
                    "weight" => $seller['weight'],
                    "courier" => $courier
                ]
            ]);
            $res = json_decode($ongkir->getBody()->__toString());
            $ongkirs = $res->rajaongkir->results;
            $ongkirProducts[] = $ongkirs;
        }

        foreach($ongkirProducts as $ongkir) {
            foreach($ongkir as $o) {
                $ongkirCosts['code'] = $o->code;
                $ongkirCosts['name'] = $o->name;
                foreach($o->costs as $i => $ong) {
                    $ongkirCosts['costs'][$i]['service'] = $ong->service;
                    $ongkirCosts['costs'][$i]['description'] = $ong->description;
                    foreach($ong->cost as $ix => $ongCost) {
                        $costs += $ongCost->value;
                        $ongkirCosts['costs'][$i]['cost'][$ix]['value'] = $costs;
                        $ongkirCosts['costs'][$i]['cost'][$ix]['etd'] = $ongCost->etd;
                        $ongkirCosts['costs'][$i]['cost'][$ix]['note'] = $ongCost->note;
                    }
                }
            }
        }
        
        return $ongkirCosts;
    }
}