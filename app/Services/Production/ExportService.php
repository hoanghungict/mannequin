<?php namespace App\Services\Production;

use \App\Services\ExportServiceInterface;
use App\Repositories\ExportRepositoryInterface;
use App\Repositories\ExportDetailRepositoryInterface;
use App\Repositories\ProductOptionRepositoryInterface;
use App\Repositories\AdminUserNotificationRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\AdminUserRepositoryInterface;

class ExportService extends BaseService implements ExportServiceInterface
{ 
    /** @var \App\Repositories\ExportRepositoryInterface */
    protected $exportRepository;

    /** @var \App\Repositories\ExportDetailRepositoryInterface */
    protected $exportDetailRepository;

    /** @var \App\Repositories\ProductOptionRepositoryInterface */
    protected $productOptionRepository;
    /** @var \App\Repositories\AdminUserNotificationRepositoryInterface */
    protected $adminUserNotificationRepository;
    /** @var \App\Repositories\ProductRepositoryInterface */
    protected $productRepository;

    public function __construct(
        ExportRepositoryInterface                $exportRepository,
        ExportDetailRepositoryInterface          $exportDetailRepository,
        ProductOptionRepositoryInterface         $productOptionRepository,
        AdminUserNotificationRepositoryInterface $adminUserNotificationRepository,
        ProductRepositoryInterface               $productRepository,
        AdminUserRepositoryInterface             $adminUserRepository
    ) {
        $this->exportRepository                = $exportRepository;
        $this->exportDetailRepository          = $exportDetailRepository;
        $this->productOptionRepository         = $productOptionRepository;
        $this->adminUserNotificationRepository = $adminUserNotificationRepository;
        $this->productRepository               = $productRepository;
        $this->adminUserRepository             = $adminUserRepository;
    }
    
    public function saveExportDetails( $export, $products )
    {
        $totalAmount = $export->total_amount;

        foreach( $products as $product ) {
            $productOption  = $this->productOptionRepository->find($product['option_id']);
            $productName = $this->productRepository->find($product['id'])['name'];
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
                $admin_users = $this->adminUserRepository->all();
                foreach($admin_users as $admin_user)
                {
                    if($quantity < 10){
                        $this->adminUserNotificationRepository->create(
                            [
                                'user_id'        => $admin_user->id,
                                'category_type'  => 'cảnh báo sản phẩm ',
                                'type'           => 'cảnh báo',
                                'data'           => '',
                                'content'        => 'Sản phẩm '.$productName.' sắp hết',
                                'locale'         => '',
                                'sent_at'        => time(),
                                'read'           => 0,
                            ]
                        );
                    }
                }
            }
        }

        $this->exportRepository->update( $export, ['total_amount' => $totalAmount] );
    }
}
