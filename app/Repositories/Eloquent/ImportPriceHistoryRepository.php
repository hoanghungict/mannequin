<?php namespace App\Repositories\Eloquent;

use \App\Repositories\ImportPriceHistoryRepositoryInterface;
use \App\Models\ImportPriceHistory;

class ImportPriceHistoryRepository extends SingleKeyModelRepository implements ImportPriceHistoryRepositoryInterface
{

    public function getBlankModel()
    {
        return new ImportPriceHistory();
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
