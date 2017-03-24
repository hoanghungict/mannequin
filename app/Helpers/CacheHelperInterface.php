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
}
