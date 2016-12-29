<?php

namespace App\Presenters;

class ProductPresenter extends BasePresenter
{
    protected $multilingualFields = [];

    protected $imageFields = [];

    public function getCurrentQuantity() {
        $options = $this->entity->options;
        $quantity = 0;
        if( count($options) ) {
            foreach( $options as $option ) {
                $quantity += $option['quantity'];
            }
        }
        return number_format($quantity, 0, ",", " ");
    }

    public function getRangeImportPrice() {
        $options = $this->entity->options;
        $maxPrice = 0;
        $minPrice = 0;
        if( count($options) ) {
            $maxPrice = $options[0]['import_price'];
            $minPrice = $options[0]['import_price'];
            foreach( $options as $option ) {
                if( $option['import_price'] < $minPrice ) {
                    $minPrice = $option['import_price'];
                }
                if( $option['import_price'] > $maxPrice ) {
                    $maxPrice = $option['import_price'];
                }
            }
        }
        return ($minPrice == $maxPrice) ? $minPrice : (number_format($minPrice, 0, ",", " ") . " ~ " . number_format($maxPrice, 0, ",", " ")) ;
    }

    public function getRangeExportPrice() {
        $options = $this->entity->options;
        $maxPrice = 0;
        $minPrice = 0;
        if( count($options) ) {
            $maxPrice = $options[0]['export_price'];
            $minPrice = $options[0]['export_price'];
            foreach( $options as $option ) {
                if( $option['export_price'] < $minPrice ) {
                    $minPrice = $option['export_price'];
                }
                if( $option['export_price'] > $maxPrice ) {
                    $maxPrice = $option['export_price'];
                }
            }
        }
        return ($minPrice == $maxPrice) ? $minPrice : (number_format($minPrice, 0, ",", " ") . " ~ " . number_format($maxPrice, 0, ",", " ")) ;
    }

    public function getStandardOption() {
        $options = $this->entity->options;
        if( count($options) ) {
            $standardOption = null;
            foreach( $options as $option ) {
                if( $option['property_value_id'] == '[]' ) {
                    $standardOption = $option;
                }
            }
            return $standardOption;
        }

        return null;
    }
}
