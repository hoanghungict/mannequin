<?php namespace App\Repositories\Eloquent;

use \App\Repositories\ImportRepositoryInterface;
use \App\Models\Import;

class ImportRepository extends SingleKeyModelRepository implements ImportRepositoryInterface
{

    public function getBlankModel()
    {
        return new Import();
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
