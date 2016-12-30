<?php namespace App\Repositories;

interface ProductRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    /**
     * Get products with filter conditions
     *
     * @param array     $filter ['keyword', $price['from'], $price['to'], $subcategory]
     * @return array    App\Model\Product
     * */
    public function getWithFilter($filter, $order, $direction, $offset, $limit);

    /**
     * Count products with filter conditions
     *
     * @param array     $filter ['keyword', $price['from'], $price['to'], $subcategory]
     * @return array    App\Model\Product
     * */
    public function countWithFilter($filter);
}