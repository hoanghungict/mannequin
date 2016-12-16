<?php namespace App\Repositories\Eloquent;

use \App\Repositories\CustomerRepositoryInterface;
use \App\Models\Customer;

class CustomerRepository extends SingleKeyModelRepository implements CustomerRepositoryInterface
{

    public function getBlankModel()
    {
        return new Customer();
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
