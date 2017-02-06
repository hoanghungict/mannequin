<?php namespace App\Services\Production;

use \App\Services\ImportServiceInterface;
use App\Repositories\ImportRepositoryInterface;
use App\Repositories\ImportDetailRepositoryInterface;
use App\Repositories\ProductOptionRepositoryInterface;

class ImportService extends BaseService implements ImportServiceInterface
{

    /** @var \App\Repositories\ImportRepositoryInterface */
    protected $importRepository;

    /** @var \App\Repositories\ImportDetailRepositoryInterface */
    protected $importDetailRepository;

    /** @var \App\Repositories\ProductOptionRepositoryInterface */
    protected $productOptionRepository;

    public function __construct(
        ImportRepositoryInterface           $importRepository,
        ImportDetailRepositoryInterface     $importDetailRepository,
        ProductOptionRepositoryInterface    $productOptionRepository
    ) {
        $this->importRepository             = $importRepository;
        $this->importDetailRepository       = $importDetailRepository;
        $this->productOptionRepository      = $productOptionRepository;
    }

    public function saveImportDetails( $import, $products )
    {
        $totalAmount = 0;

        foreach( $products as $product ) {
            $importDetail = $this->importDetailRepository->create(
                [
                    'import_id'         => $import->id,
                    'product_id'        => $product['id'],
                    'option_id'         => $product['option_id'],
                    'prices'            => $product['import_price'],
                    'quantity'          => $product['quantity'],
                    'unit_id'           => $product['unit_id'],
                ]
            );

            if( !empty($importDetail) ) {
                $totalAmount += ($importDetail->quantity * $importDetail->prices);
            }

            // update product option table
            $productOption  = $this->productOptionRepository->find($product['option_id']);
            $quantity       = $productOption->quantity + $product['quantity'];
            $this->productOptionRepository->update( $productOption, ['quantity' => $quantity] );
        }

        $this->importRepository->update( $import, ['total_amount' => $totalAmount] );
    }
}
