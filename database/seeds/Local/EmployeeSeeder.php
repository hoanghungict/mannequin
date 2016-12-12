<?php

namespace Seeds\Local;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        for( $i = 0; $i < 20; $i++ ) {
            factory(Employee::class)->create();
        }
    }
}
