<?php namespace App\Repositories\Eloquent;

use \App\Repositories\PropertyRepositoryInterface;
use \App\Models\Property;

class PropertyRepository extends SingleKeyModelRepository implements PropertyRepositoryInterface
{

    public function getBlankModel()
    {
        return new Property();
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
