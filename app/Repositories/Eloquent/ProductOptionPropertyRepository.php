<?php namespace App\Repositories\Eloquent;

use \App\Repositories\ProductOptionPropertyRepositoryInterface;
use \App\Models\ProductOptionProperty;

class ProductOptionPropertyRepository extends SingleKeyModelRepository implements ProductOptionPropertyRepositoryInterface
{

    public function getBlankModel()
    {
        return new ProductOptionProperty();
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
