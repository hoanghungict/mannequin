<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        $this->call(AdminUserTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(SubcategoryTableSeeder::class);
        $this->call(PropertyTableSeeder::class);
        $this->call(ProvinceTableSeeder::class);
        $this->call(DistrictTableSeeder::class);
        $this->call(UnitTableSeeder::class);
        $this->call(StoreTableSeeder::class);

        if (App::environment() === 'testing') {
            // Add More Seed For Testing
        }

        if (App::environment() === 'local') {
            $this->call(Seeds\Local\DatabaseSeeder::class);
        }

        Model::reguard();
    }
}
