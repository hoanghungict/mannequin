<?php namespace App\Observers;

class DistrictObserver extends BaseObserver
{
    protected $cachePrefix = 'districts';

    public function created($model)
    {
        \Redis::hsetnx(\CacheHelper::generateCacheKey('hash_' . $this->cachePrefix), $model->id, $model);
    }

    public function updated($model)
    {
        \Redis::hset(\CacheHelper::generateCacheKey('hash_' . $this->cachePrefix), $model->id, $model);
    }

    public function deleted($model)
    {
        \Redis::hdel(\CacheHelper::generateCacheKey('hash_' . $this->cachePrefix), $model->id);
    }
}