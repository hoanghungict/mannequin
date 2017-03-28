<?php namespace App\Observers;

use Illuminate\Support\Facades\Redis;

class UnitObserver extends BaseObserver
{
    protected $cachePrefix = 'units';

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