<?php namespace App\Repositories\Eloquent;

use \App\Repositories\UnitRepositoryInterface;
use \App\Models\Unit;

class UnitRepository extends SingleKeyModelRepository implements UnitRepositoryInterface
{

    public function getBlankModel()
    {
        return new Unit();
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
