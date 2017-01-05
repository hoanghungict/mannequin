<?php namespace App\Services\Production;

use \App\Services\PropertyValueServiceInterface;
use App\Repositories\PropertyRepositoryInterface;
use App\Repositories\PropertyValueRepositoryInterface;

class PropertyValueService extends BaseService implements PropertyValueServiceInterface
{
    /** @var \App\Repositories\PropertyRepositoryInterface */
    protected $propertyRepository;

    /** @var \App\Repositories\PropertyValueRepositoryInterface */
    protected $propertyValueRepository;

    public function __construct(
        PropertyRepositoryInterface         $propertyRepository,
        PropertyValueRepositoryInterface    $propertyValueRepository
    ) {
        $this->propertyRepository           = $propertyRepository;
        $this->propertyValueRepository      = $propertyValueRepository;
    }

    public function getPropertyName($propertyValueId) {
        $propertyValue  = $this->propertyValueRepository->find($propertyValueId);
        $property       = $this->propertyRepository->find($propertyValue->property_id);

        return $property['name'] . ": " . $propertyValue['value'];
    }
}
