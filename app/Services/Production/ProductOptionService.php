<?php namespace App\Services\Production;

use \App\Services\ProductOptionServiceInterface;
use App\Repositories\ProductOptionRepositoryInterface;
use App\Services\PropertyServiceInterface;
use App\Repositories\PropertyValueRepositoryInterface;
use App\Services\PropertyValueServiceInterface;

class ProductOptionService extends BaseService implements ProductOptionServiceInterface
{
    /** @var \App\Repositories\ProductOptionRepositoryInterface */
    protected $productOptionRepository;

    /** @var \App\Services\PropertyServiceInterface */
    protected $propertyService;

    /** @var \App\Repositories\PropertyValueRepositoryInterface */
    protected $propertyValueRepository;

    /** @var \App\Services\PropertyValueServiceInterface */
    protected $propertyValueService;

    public function __construct(
        ProductOptionRepositoryInterface    $productOptionRepository,
        PropertyServiceInterface            $propertyService,
        PropertyValueRepositoryInterface    $propertyValueRepository,
        PropertyValueServiceInterface       $propertyValueService
    ) {
        $this->productOptionRepository  = $productOptionRepository;
        $this->propertyService          = $propertyService;
        $this->propertyValueRepository  = $propertyValueRepository;
        $this->propertyValueService     = $propertyValueService;
    }

    public function createOptions($productId, $options) {
        $standardOption = $this->getStandardOption($productId);

        foreach( $options as $option ) {
            $properties = isset($option['properties']) ? json_decode($option['properties'], true) : [];
            $propertyValueIds = [];
            if( count($properties) ) {
                foreach( $properties as $propertyName => $value ) {
                    $property = $this->propertyService->create($propertyName);
                    $propertyValue = $this->propertyValueRepository->create(
                        [
                            'property_id' => $property['id'],
                            'value'       => $value
                        ]
                    );
                    array_push($propertyValueIds, $propertyValue->id);
                }
            } else {
                continue;
            }
            $productOption = $this->productOptionRepository->create(
                [
                    'product_id'        => $productId,
                    'property_value_id' => json_encode($propertyValueIds),
                    'import_price'      => $option['import_price'],
                    'export_price'      => $option['export_price'],
                    'quantity'          => $option['quantity'],
                    'unit_id'           => $standardOption['unit_id']
                ]
            );
        }

        return;
    }

    public function getStandardOption($productId) {
        $option = $this->productOptionRepository->getBlankModel();
        return $option->where(
            [
                'product_id' => $productId,
                'property_value_id' => '[]'
            ]
        )
            ->first();
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
