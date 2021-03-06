<?php namespace App\Services;

interface ProductOptionServiceInterface extends BaseServiceInterface
{
    /**
     * Create new Options for product
     *
     * @params  int     $productId
     *          array   $options    list options
     * @return
     * */
    public function createOptions($productId, $options);

    /**
     * Get all options of products
     *
     * @param   int     $productId
     * @return  array   $options    List options
     * */
    public function getProductOptions($productId);

    /**
     * Get all options
     *
     * @param
     * @return  array   $options    List options
     * */
    public function getAllOptionEnabled();
}