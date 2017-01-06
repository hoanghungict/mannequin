<?php namespace App\Repositories\Eloquent;

use \App\Repositories\ProductRepositoryInterface;
use \App\Models\Product;

class ProductRepository extends SingleKeyModelRepository implements ProductRepositoryInterface
{

    public function getBlankModel()
    {
        return new Product();
    }

    public function rules()
    {
        return [
            'code'           => 'string|required',
            'name'           => 'string|required',
            'subcategory_id' => 'integer|required',
            'unit_id'        => 'integer|required',
        ];
    }

    public function messages()
    {
        return [
        ];
    }

    public function getWithFilter($filter, $order, $direction, $offset, $limit)
    {
        $productModel = $this->getBlankModel()
                             ->select( 'products.id', 'products.code', 'products.name', 'products.subcategory_id', 'products.is_enabled' );

        $keyword = isset($filter['keyword']) ? $filter['keyword'] : '';
        $productModel = $productModel->where(function ($subquery) use ($keyword) {
            $subquery->where('code', 'like', '%'.$keyword.'%')
                         ->orWhere('name', 'like', '%'.$keyword.'%')
                         ->orWhere('descriptions', 'like', '%'.$keyword.'%');
        });

        return $productModel->orderBy($order, $direction)->skip($offset)->take($limit)->get();
    }

    public function countWithFilter($filter)
    {
        $productModel = $this->getBlankModel()
                             ->select( 'products.id', 'products.code', 'products.name', 'products.subcategory_id', 'products.is_enabled' );

        $keyword = isset($filter['keyword']) ? $filter['keyword'] : '';
        $productModel = $productModel->where(function ($subquery) use ($keyword) {
            $subquery->where('code', 'like', '%'.$keyword.'%')
                     ->orWhere('name', 'like', '%'.$keyword.'%')
                     ->orWhere('descriptions', 'like', '%'.$keyword.'%');
        });

        return $productModel->count();
    }
}
