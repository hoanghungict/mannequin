<?php

namespace App\Presenters;

use App\Models\Category;
use Illuminate\Support\Facades\Redis;

class SubcategoryPresenter extends BasePresenter
{
    protected $multilingualFields = [];

    protected $imageFields = [];


    /**
     * @return \App\Models\Category
     * */
    public function category()
    {
        if( \CacheHelper::cacheRedisEnabled() ) {
            $cached = Redis::hget(\CacheHelper::generateCacheKey('hash_categories'), $this->entity->category_id);
            if( $cached ) {
                $category = new Category(json_decode($cached, true));
                $category['id'] = json_decode($cached, true)['id'];
                return $category;
            } else {
                $category = $this->entity->category;
                Redis::hsetnx(\CacheHelper::generateCacheKey('hash_categories'), $this->entity->category_id, $category);
                return $category;
            }
        }

        $category = $this->entity->category;
        return $category;
    }
}
