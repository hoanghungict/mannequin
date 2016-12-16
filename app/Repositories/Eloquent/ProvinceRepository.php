<?php namespace App\Repositories\Eloquent;

use \App\Repositories\ProvinceRepositoryInterface;
use \App\Models\Province;

class ProvinceRepository extends SingleKeyModelRepository implements ProvinceRepositoryInterface
{

    public function getBlankModel()
    {
        return new Province();
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
