<?php namespace App\Repositories\Eloquent;

use \App\Repositories\ProductOptionRepositoryInterface;
use \App\Models\ProductOption;

class ProductOptionRepository extends SingleKeyModelRepository implements ProductOptionRepositoryInterface
{

    public function getBlankModel()
    {
        return new ProductOption();
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
