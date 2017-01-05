<?php namespace App\Repositories\Eloquent;

use \App\Repositories\PropertyValueRepositoryInterface;
use \App\Models\PropertyValue;

class PropertyValueRepository extends SingleKeyModelRepository implements PropertyValueRepositoryInterface
{

    public function getBlankModel()
    {
        return new PropertyValue();
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
