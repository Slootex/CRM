<?php

namespace Database\Seeders;

use App\Http\Controllers\packtisch_CONTROLLER;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class active_orders_person_datas extends Seeder
{



    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $counter = 0;
        $c = 1000;
        while($counter < $c) {
            DB::table('active_orders_person_datas')->insert([
                'process_id' => Str::random(10),
                'employee' => Str::random(10),
                'gender' => Str::random(10),
                'firstname' => Str::random(10),
                'lastname' => Str::random(10),
                'email' => Str::random(10),
                'phone_number' => Str::random(10),
                'mobile_number' => Str::random(10),
                'home_street_number' => Str::random(10),
                'home_zipcode' => Str::random(10),
                'home_city' => Str::random(10),
                'home_country' => Str::random(10),
                'pricemwst' => Str::random(10),
                'submit_type' => Str::random(10),
                'created_at' => '2023-06-06 16:31:41',
                'updated_at' => '2023-06-06 16:31:41',
    
            ]);
            $counter++;
        }
    } 
}
