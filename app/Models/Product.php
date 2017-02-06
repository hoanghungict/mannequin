<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Base
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'subcategory_id',
        'unit_id',
        'descriptions',
        'is_enabled',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates  = ['deleted_at'];

    protected $presenter = \App\Presenters\ProductPresenter::class;

    // Relations
    public function subcategory()
    {
        return $this->belongsTo(\App\Models\Subcategory::class, 'subcategory_id', 'id');
    }

    public function options()
    {
        return $this->hasMany(\App\Models\ProductOption::class, 'product_id', 'id');
    }

    public function images()
    {
        return $this->belongsToMany(\App\Models\Image::class, ProductImage::getTableName(), 'product_id', 'image_id');
    }
  
    public function unit()
    {
        return $this->belongsTo(\App\Models\Unit::class, 'unit_id', 'id');
    }

    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'             => $this->id,
            'code'           => $this->code,
            'name'           => $this->name,
            'subcategory_id' => $this->subcategory_id,
            'unit_id'        => $this->unit_id,
            'descriptions'   => $this->descriptions,
            'is_enabled'     => $this->is_enabled,
        ];
    }

}
