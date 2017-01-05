<?php namespace App\Services;

interface PropertyValueServiceInterface extends BaseServiceInterface
{
    public function getPropertyName($productId);
}