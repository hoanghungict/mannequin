<?php namespace App\Repositories\Eloquent;

use \App\Repositories\ExportRepositoryInterface;
use \App\Models\Export;

class ExportRepository extends SingleKeyModelRepository implements ExportRepositoryInterface
{

    public function getBlankModel()
    {
        return new Export();
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
