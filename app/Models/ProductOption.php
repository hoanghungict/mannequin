<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ProductOption extends Base
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_options';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'property_value_id',
        'import_price',
        'export_price',
        'quantity',
        'is_block',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates  = ['deleted_at'];

    protected $presenter = \App\Presenters\ProductOptionPresenter::class;

    // Relations
    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id', 'id');
    }
    
    public function properties()
    {
        return $this->belongsToMany(\App\Models\PropertyValue::class, ProductOptionProperty::getTableName(), 'product_option_id', 'property_value_id');
    }



    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'                => $this->id,
            'product_id'        => $this->product_id,
            'property_value_id' => $this->property_value_id,
            'import_price'      => $this->import_price,
            'export_price'      => $this->export_price,
            'quantity'          => $this->quantity,
            'is_block'          => $this->is_block,
        ];
    }

}
