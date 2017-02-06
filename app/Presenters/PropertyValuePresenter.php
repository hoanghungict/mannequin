<?php

namespace App\Presenters;

class PropertyValuePresenter extends BasePresenter
{
    protected $multilingualFields = [];

    protected $imageFields = [];

    public function getPropertyName() {
        $propertyValue  = $this->entity;
        $property       = $propertyValue->property;

        return $property['name'] . ": " . $propertyValue['value'];
    }
}
