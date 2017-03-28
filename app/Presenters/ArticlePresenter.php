<?php

namespace App\Presenters;

use Illuminate\Support\Facades\Redis;
use App\Models\Image;

class ArticlePresenter extends BasePresenter
{
    /**
     * @return \App\Models\Image
     * */
    public function coverImage()
    {
        $cached = Redis::hget(\CacheHelper::generateCacheKey('hash_images'), $this->entity->cover_image_id);
        if( $cached ) {
            $image = new Image(json_decode($cached, true));
            $image['id'] = json_decode($cached, true)['id'];
            return $image;
        } else {
            $image = $this->entity->coverImage;
            Redis::hsetnx(\CacheHelper::generateCacheKey('hash_images'), $this->entity->cover_image_id, $image);
            return $image;
        }
    }
}
