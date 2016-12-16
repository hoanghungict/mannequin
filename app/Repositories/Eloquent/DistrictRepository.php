<?php namespace App\Repositories\Eloquent;

use \App\Repositories\DistrictRepositoryInterface;
use \App\Models\District;

class DistrictRepository extends SingleKeyModelRepository implements DistrictRepositoryInterface
{

    public function getBlankModel()
    {
        return new District();
    }

    public function rules()
    {
        return [
        ];
    }

    public function messages()
    {
        return [
        ];
    }

}
