<?php namespace App\Repositories\Eloquent;

use \App\Repositories\ImportDetailRepositoryInterface;
use \App\Models\ImportDetail;

class ImportDetailRepository extends SingleKeyModelRepository implements ImportDetailRepositoryInterface
{

    public function getBlankModel()
    {
        return new ImportDetail();
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
