<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $digits = 3;
        for ($i=0; $i <30 ; $i++) { 
            Customer::create([
                'customer_code' => 'KH'.rand(pow(10, $digits-1), pow(10, $digits)-1),
                'name' => 'cong'.rand(pow(10, $digits-1), pow(10, $digits)-1),
                'address' => null,
                'phone' => rand(pow(10, 10-1), pow(10, 10)-1)
            ]);
        }
    }
}
