<?php namespace App\Repositories\Eloquent;

use \App\Repositories\ExportDetailRepositoryInterface;
use \App\Models\ExportDetail;

class ExportDetailRepository extends SingleKeyModelRepository implements ExportDetailRepositoryInterface
{

    public function getBlankModel()
    {
        return new ExportDetail();
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
