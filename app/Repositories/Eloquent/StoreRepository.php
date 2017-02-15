<?php namespace App\Repositories\Eloquent;

use \App\Repositories\StoreRepositoryInterface;
use \App\Models\Store;

class StoreRepository extends SingleKeyModelRepository implements StoreRepositoryInterface
{

    public function getBlankModel()
    {
        return new Store();
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
