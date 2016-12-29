<?php namespace App\Repositories\Eloquent;

use \App\Repositories\SubcategoryRepositoryInterface;
use \App\Models\Subcategory;

class SubcategoryRepository extends SingleKeyModelRepository implements SubcategoryRepositoryInterface
{

    public function getBlankModel()
    {
        return new Subcategory();
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
