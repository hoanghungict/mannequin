<?php

namespace Seeds\Local;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CustomerSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(PropertyValueSeeder::class);
        $this->call(ProductSeeder::class);
    }
}
