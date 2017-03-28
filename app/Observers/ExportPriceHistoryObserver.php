<?php namespace App\Observers;

use Illuminate\Support\Facades\Redis;

class ExportPriceHistoryObserver extends BaseObserver
{
    protected $cachePrefix = 'export_price_histories';

    public function created($model)
    {
        Redis::hsetnx(\CacheHelper::generateCacheKey('hash_' . $this->cachePrefix), $model->id, $model);
    }

    public function updated($model)
    {
        Redis::hset(\CacheHelper::generateCacheKey('hash_' . $this->cachePrefix), $model->id, $model);
    }

    public function deleted($model)
    {
        Redis::hdel(\CacheHelper::generateCacheKey('hash_' . $this->cachePrefix), $model->id);
    }
}