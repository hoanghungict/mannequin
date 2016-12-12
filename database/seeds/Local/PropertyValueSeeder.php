<?php

namespace Seeds\Local;

use App\Models\Property;
use App\Models\PropertyValue;
use Illuminate\Database\Seeder;

class PropertyValueSeeder extends Seeder
{
    public function run() {
        $properties = Property::all();
        foreach( $properties as $property ) {
            foreach( range(2, 5) as $i ) {
                factory(PropertyValue::class)->create(
                    [
                        'property_id' => $property[ 'id' ]
                    ]
                );
            }
        }
    }
}
