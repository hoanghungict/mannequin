<?php namespace App\Repositories\Eloquent;

use \App\Repositories\ExportPriceHistoryRepositoryInterface;
use \App\Models\ExportPriceHistory;

class ExportPriceHistoryRepository extends SingleKeyModelRepository implements ExportPriceHistoryRepositoryInterface
{

    public function getBlankModel()
    {
        return new ExportPriceHistory();
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
