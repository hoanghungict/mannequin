<?php

namespace Seeds\Local;

use App\Models\Product;
use App\Models\ProductOption;
use App\Models\PropertyValue;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $subcategories  = Subcategory::all();
        $propertyValues = PropertyValue::all()->count();
        foreach( $subcategories as $subcategory ) {
            foreach( range(5, 10) as $numberProduct ) {
                $product = factory(Product::class)->create(
                    [
                        'subcategory_id' => $subcategory->id
                    ]
                );
                // Create options
                factory( ProductOption::class )->create(
                    [
                        'product_id'        => $product->id,
                        'property_value_id' => json_encode([]),
                        // 'unit_id'           => $product->id,
                    ]
                );
                foreach( range(1, 5) as $numberProductOption ) {
                    $propertyValueId = [];
                    foreach( range(1, 5) as $numberPropertyValue ) {
                        array_push($propertyValueId, rand(1, $propertyValues));
                    }
                    factory( ProductOption::class )->create(
                        [
                            'product_id'        => $product->id,
                            'property_value_id' => json_encode($propertyValueId),
                            // 'unit_id'           => $product->id,
                        ]
                    );
                }
            }
        }
    }
}
