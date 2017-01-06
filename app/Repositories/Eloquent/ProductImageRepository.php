<?php namespace App\Repositories\Eloquent;

use \App\Repositories\ProductImageRepositoryInterface;
use \App\Models\ProductImage;

class ProductImageRepository extends SingleKeyModelRepository implements ProductImageRepositoryInterface
{

    public function getBlankModel()
    {
        return new ProductImage();
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
