<?php

namespace Seeds\Local;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        for( $i = 0; $i < 20; $i++ ) {
            factory(Customer::class)->create();
        }
    }
}
