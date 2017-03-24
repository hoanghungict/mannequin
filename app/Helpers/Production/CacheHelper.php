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
}
