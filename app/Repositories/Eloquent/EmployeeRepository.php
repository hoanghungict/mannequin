<?php namespace App\Repositories\Eloquent;

use \App\Repositories\EmployeeRepositoryInterface;
use \App\Models\Employee;

class EmployeeRepository extends SingleKeyModelRepository implements EmployeeRepositoryInterface
{

    public function getBlankModel()
    {
        return new Employee();
    }

    public function rules()
    {
        return [
            'name'         => 'required|string',
            'telephone'    => 'required|string',
            'province_id'  => 'required|numeric',
            'district_id'  => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
        ];
    }

}
