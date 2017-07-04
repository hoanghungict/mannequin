<?php namespace App\Observers;

use Illuminate\Support\Facades\Redis;

class SiteConfigurationObserver extends BaseObserver
{
    protected $cachePrefix = 'site_configurations';

    public function created($user)
    {
        if( \CacheHelper::cacheRedisEnabled() ) {
            Redis::hsetnx(\CacheHelper::generateCacheKey('hash_' . $this->cachePrefix), $user->id, $user);
        }
    }

    public function updated($user)
    {
        if( \CacheHelper::cacheRedisEnabled() ) {
            Redis::hset(\CacheHelper::generateCacheKey('hash_' . $this->cachePrefix), $user->id, $user);
        }
    }

    public function deleted($user)
    {
        if( \CacheHelper::cacheRedisEnabled() ) {
            Redis::hdel(\CacheHelper::generateCacheKey('hash_' . $this->cachePrefix), $user->id);
        }
    }
}