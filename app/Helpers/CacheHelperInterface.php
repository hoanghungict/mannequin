<?php

namespace App\Helpers;

interface CacheHelperInterface
{
    /**
     * Generate Cache key
     *
     * @params  string  $name
     *
     * @return  string
     */
    public function generateCacheKey($name);


    /**
     * Check is enabled cache & redis
     *
     * @params
     *
     * @return  boolean
     */
    public function cacheRedisEnabled();
}
