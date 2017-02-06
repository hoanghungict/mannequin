<?php

namespace App\Presenters; 

class ProductOptionPresenter extends BasePresenter
{
    protected $multilingualFields = [];

    protected $imageFields = [];

    public function getProductOptionName()
    {
        $option = $this->entity;
        $properties = $option->properties;
        if( !count($properties) ) {
            $name = trans('admin.pages.common.label.standard_option');
        } else {
            $properties     = '';
            foreach( $option->properties as $key2 => $property ) {
                $properties .= $key2 ? (' | ' . $property->present()->getPropertyName) : $property->present()->getPropertyName;
            }
            $name = $properties;
        }
        return $name;
    }
}
