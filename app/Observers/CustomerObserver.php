<?php namespace App\Observers;

class CustomerObserver extends BaseObserver
{
    protected $cachePrefix = 'customers';

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