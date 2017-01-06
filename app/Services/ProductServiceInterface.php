<?php namespace App\Services;

interface ProductServiceInterface extends BaseServiceInterface
{
    public function updateImages($id, $images);
}