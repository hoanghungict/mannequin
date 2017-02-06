<?php namespace App\Services\Production;

use \App\Services\ProductOptionServiceInterface;
use App\Repositories\ProductOptionRepositoryInterface;
use App\Services\PropertyServiceInterface;
use App\Repositories\PropertyValueRepositoryInterface;
use App\Services\PropertyValueServiceInterface;
use App\Repositories\ProductOptionPropertyRepositoryInterface;

class ProductOptionService extends BaseService implements ProductOptionServiceInterface
{
    /** @var \App\Repositories\ProductOptionRepositoryInterface */
    protected $productOptionRepository;

    /** @var \App\Services\PropertyServiceInterface */
    protected $propertyService;

    /** @var \App\Repositories\PropertyValueRepositoryInterface */
    protected $propertyValueRepository;

    /** @var \App\Repositories\ProductOptionPropertyRepositoryInterface */
    protected $productOptionPropertyRepository;

    /** @var \App\Services\PropertyValueServiceInterface */
    protected $propertyValueService;

    public function __construct(
        ProductOptionRepositoryInterface            $productOptionRepository,
        PropertyServiceInterface                    $propertyService,
        PropertyValueRepositoryInterface            $propertyValueRepository,
        PropertyValueServiceInterface               $propertyValueService,
        ProductOptionPropertyRepositoryInterface    $productOptionPropertyRepository
    ) {
        $this->productOptionRepository          = $productOptionRepository;
        $this->propertyService                  = $propertyService;
        $this->propertyValueRepository          = $propertyValueRepository;
        $this->propertyValueService             = $propertyValueService;
        $this->productOptionPropertyRepository  = $productOptionPropertyRepository;
    }

    public function createOptions($productId, $options) {
        foreach( $options as $option ) {
            $properties = isset($option['properties']) ? json_decode($option['properties'], true) : [];
            if( count($properties) ) {
                $productOption = $this->productOptionRepository->create(
                    [
                        'product_id'        => $productId,
                        'import_price'      => $option['import_price'],
                        'export_price'      => $option['export_price'],
                        'quantity'          => $option['quantity']
                    ]
                );

                foreach( $properties as $propertyName => $value ) {
                    $property = $this->propertyService->create($propertyName);
                    $propertyValue = $this->propertyValueRepository->create(
                        [
                            'property_id' => $property['id'],
                            'value'       => $value
                        ]
                    );

                    $this->productOptionPropertyRepository->create(
                        [
                            'product_option_id' => $productOption->id,
                            'property_value_id' => $propertyValue->id
                        ]
                    );
                }
            } else {
                continue;
            }

        }

        return;
    }

    public function getProductOptions($productId) {
        $options = $this->productOptionRepository->getBlankModel()->where(['product_id' => $productId])->get();
        foreach( $options as $key => $option ) {
            if( $option['property_value_id'] == '[]' ) {
                unset($options[$key]);
                continue;
            } else {
                $properties     = '';
                $propertyIds    = json_decode($option['property_value_id']);
                foreach( $propertyIds as $key2 => $id ) {
                    $propertyValueName = $this->propertyValueService->getPropertyName($id);
                    $properties .= $key2 ? (' | ' . $propertyValueName) : $propertyValueName;
                }
                $options[$key]['properties'] = $properties;
            }
        }
        return $options;
    }

    public function getAllOptionEnabled()
    {
        $options = $this->productOptionRepository->getBlankModel()->where('id', '<', '50')->get();
//        $options = $this->productOptionRepository->allEnabled();

        foreach( $options as $key => $option ) {
            $properties = $option->properties;
            if( !count($properties) ) {
                $options[$key]['name'] = trans('admin.pages.common.label.standard_option');
                continue;
            } else {
                $optionName = '';
                foreach( $properties as $key2 => $propertyValue ) {
                    $propertyValueName = $propertyValue->present()->getPropertyName;
                    $optionName .= $key2 ? (' | ' . $propertyValueName) : $propertyValueName;
                }
                $options[$key]['name'] = $optionName;
            }
        }
        return $options;
    }
}
