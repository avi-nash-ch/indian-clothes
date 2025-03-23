<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OfferFor;

class OfferForSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'offer_for' => 'For Factory'],
            ['id' => 2, 'offer_for' => 'For Salesman'],
            ['id' => 3, 'offer_for' => 'For Distributor'],
            ['id' => 4, 'offer_for' => 'For Shopper'],
            ['id' => 5, 'offer_for' => 'For Company'],
        ];

        OfferFor::insert($data);
    }
}
