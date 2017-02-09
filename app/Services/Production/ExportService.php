<?php namespace App\Services\Production;

use \App\Services\ExportServiceInterface;
use App\Repositories\ExportRepositoryInterface;
use App\Repositories\ExportDetailRepositoryInterface;
use App\Repositories\ProductOptionRepositoryInterface;

class ExportService extends BaseService implements ExportServiceInterface
{ 
    /** @var \App\Repositories\ExportRepositoryInterface */
    protected $exportRepository;

    /** @var \App\Repositories\ExportDetailRepositoryInterface */
    protected $exportDetailRepository;

    /** @var \App\Repositories\ProductOptionRepositoryInterface */
    protected $productOptionRepository;

    public function __construct(
        ExportRepositoryInterface           $exportRepository,
        ExportDetailRepositoryInterface     $exportDetailRepository,
        ProductOptionRepositoryInterface    $productOptionRepository
    ) {
        $this->exportRepository             = $exportRepository;
        $this->exportDetailRepository       = $exportDetailRepository;
        $this->productOptionRepository      = $productOptionRepository;
    }
    
    public function saveExportDetails( $export, $products )
    {
        $totalAmount = $export->total_amount;

        foreach( $products as $product ) {
            $productOption  = $this->productOptionRepository->find($product['option_id']);
            if( $productOption->quantity >= $product['quantity'] ) {
                $exportDetail = $this->exportDetailRepository->create(
                    [
                        'export_id'         => $export->id,
                        'product_id'        => $product['id'],
                        'option_id'         => $product['option_id'],
                        'prices'            => $product['export_price'],
                        'quantity'          => $product['quantity'],
                        'unit_id'           => $product['unit_id'],
                    ]
                );

                if( !empty($exportDetail) ) {
                    $totalAmount += ($exportDetail->quantity * $exportDetail->prices);
                }

                $quantity       = $productOption->quantity - $product['quantity'];
                $this->productOptionRepository->update( $productOption, ['quantity' => $quantity] );
            }
        }

        $this->exportRepository->update( $export, ['total_amount' => $totalAmount] );
    }
}
