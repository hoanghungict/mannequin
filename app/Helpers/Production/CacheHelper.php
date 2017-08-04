<?php

namespace App\Helpers\Production;

use App\Helpers\CacheHelperInterface;

class CacheHelper implements CacheHelperInterface
{
    public $appPrefix = 'boilerplate';

    public function generateCacheKey($name)
    {
        return $this->appPrefix . '_' . $name;
    }

    public function cacheRedisEnabled()
    {
        return ( env('CACHE_ENABLED') && env('CACHE_DRIVER') == 'redis' ) ? true : false;
    }
}
