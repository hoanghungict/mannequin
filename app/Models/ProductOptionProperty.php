<?php namespace App\Models;


class ProductOptionProperty extends Base 
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_option_properties';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_option_id',
        'property_value_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = [];

    protected $presenter = \App\Presenters\ProductOptionPropertyPresenter::class;

    // Relations
    public function productOption() 
    {
        return $this->belongsTo( \App\Models\ProductOption::class, 'product_option_id', 'id' );
    }

    public function propertyValue() 
    {
        return $this->belongsTo( \App\Models\PropertyValue::class, 'property_value_id', 'id' );
    }



    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray() {
        return [
            'id'                => $this->id,
            'product_option_id' => $this->product_option_id,
            'property_value_id' => $this->property_value_id,
        ];
    }

}
