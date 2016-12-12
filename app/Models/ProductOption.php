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
        'unit_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates  = ['deleted_at'];

//    protected $presenter = \App\Presenters\SubcategoryPresenter::class;

    // Relations
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'product_id'        => $this->product_id,
            'property_value_id' => $this->property_value_id,
            'import_price'      => $this->import_price,
            'export_price'      => $this->export_price,
            'quantity'          => $this->quantity,
            'unit_id'           => $this->unit_id,
        ];
    }

}
