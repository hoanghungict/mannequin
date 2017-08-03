<?php namespace App\Services\Production;

use App\Models\Notification;
use \App\Services\ExportServiceInterface;
use App\Repositories\ExportRepositoryInterface;
use App\Repositories\ExportDetailRepositoryInterface;
use App\Repositories\ProductOptionRepositoryInterface;
use App\Repositories\AdminUserNotificationRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;

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
        ProductRepositoryInterface               $productRepository
    ) {
        $this->exportRepository                = $exportRepository;
        $this->exportDetailRepository          = $exportDetailRepository;
        $this->productOptionRepository         = $productOptionRepository;
        $this->adminUserNotificationRepository = $adminUserNotificationRepository;
        $this->productRepository               = $productRepository;
    }

    public function saveExportDetails( $export, $products )
    {
        $totalAmount = $export->total_amount;

        foreach( $products as $product ) {
            $productOption  = $this->productOptionRepository->find($product['option_id']);
            if( !is_numeric($product['quantity']) || !is_numeric($product['unit_exchange']) ) {
                continue;
            }
            if( $productOption->quantity >= ($product['quantity'] * $product['unit_exchange']) ) {
                $exportDetail = $this->exportDetailRepository->create(
                    [
                        'export_id'     => $export->id,
                        'product_id'    => $product['id'],
                        'option_id'     => $product['option_id'],
                        'prices'        => $product['export_price'],
                        'quantity'      => $product['quantity'],
                        'unit_id'       => $product['unit_id'],
                        'unit_exchange' => $product['unit_exchange'],
                    ]
                );

                if( !empty($exportDetail) ) {
                    $totalAmount += ($exportDetail->unit_exchange * $exportDetail->quantity * $exportDetail->prices);
                }

                $quantity       = $productOption->quantity - ($product['quantity'] * $product['unit_exchange']);
                $this->productOptionRepository->update( $productOption, ['quantity' => $quantity] );

                if( $quantity < config( 'notification.system.general_alert.products.number_limit_notice' ) ) {
                    $productName = $this->productRepository->find( $product[ 'id' ] )[ 'name' ];
                    $this->adminUserNotificationRepository->create(
                        [
                            'user_id'       => Notification::BROADCAST_USER_ID,
                            'category_type' => Notification::CATEGORY_TYPE_SYSTEM_MESSAGE,
                            'type'          => Notification::TYPE_GENERAL_ALERT,
                            'data'          => '',
                            'content'       => trans(
                                config('notification.system.general_alert.products.message'),
                                [
                                    'product_name' => $productName,
                                    'option_name'  => $productOption->present()->getProductOptionName
                                ]
                            ),
                            'locale'        => 'en',
                            'sent_at'       => time(),
                            'read'          => 0,
                        ]
                    );
                }
            }
        }

        $this->exportRepository->update( $export, ['total_amount' => $totalAmount] );
    }
}
