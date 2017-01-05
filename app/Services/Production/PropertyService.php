<?php namespace App\Services\Production;

use \App\Services\PropertyServiceInterface;
use App\Repositories\PropertyRepositoryInterface;

class PropertyService extends BaseService implements PropertyServiceInterface
{
    /** @var \App\Repositories\PropertyRepositoryInterface */
    protected $propertyRepository;

    public function __construct(
        PropertyRepositoryInterface     $propertyRepository
    ) {
        $this->propertyRepository       = $propertyRepository;
    }

    public function create($propertyName) {
        $propertyName   = ucfirst(mb_strtolower($propertyName, 'UTF-8'));
        $slug           = $this->createSlug($propertyName);
        $property       = $this->propertyRepository->getBySlug($slug)->first();
        if( !$property ) {
            $property = $this->propertyRepository->create(
                [
                    'name' => $propertyName,
                    'slug' => $slug
                ]
            );
        }

        return $property;
    }
}
