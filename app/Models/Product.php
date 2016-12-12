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
        'descriptions',
        'is_block',
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
    public function category()
    {
        return $this->belongsTo('App\Models\Subcategory', 'subcategory_id', 'id');
    }

    public function options()
    {
        return $this->hasMany('App\Models\ProductOption', 'product_id', 'id');
    }

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
            'descriptions'   => $this->descriptions,
            'is_block'       => $this->is_block,
        ];
    }

}
