<?php

use App\Model\Seller;
use Illuminate\Database\Seeder;

class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Seller::create([
            "name" => "seller",
            "email" => "seller@test.com",
            "password" => bcrypt("password.1"),
            "address" => "Address",
            "phone" => "087623488",
            "datebirth" => "1989-08-30"
        ]);
    }
}
