<?php namespace App\Services;

interface PropertyServiceInterface extends BaseServiceInterface
{
    public function create($propertyName);
}