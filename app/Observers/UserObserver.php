<?php namespace App\Observers;


class UserObserver extends BaseObserver
{
    protected $cachePrefix = 'users';

    public function created($user)
    {
        \Redis::hsetnx(\CacheHelper::generateCacheKey('hash_' . $this->cachePrefix), $user->id, $user);
    }

    public function updated($user)
    {
        \Redis::hset(\CacheHelper::generateCacheKey('hash_' . $this->cachePrefix), $user->id, $user);
    }

    public function deleted($user)
    {
        \Redis::hdel(\CacheHelper::generateCacheKey('hash_' . $this->cachePrefix), $user->id);
    }
}