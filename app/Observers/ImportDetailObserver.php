<?php namespace App\Observers;

class ImportDetailObserver extends BaseObserver
{
    protected $cachePrefix = 'import_details';

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