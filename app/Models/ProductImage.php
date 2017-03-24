<?php namespace App\Models;



class ProductImage extends Base
{

    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'image_id',
        'order',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates  = [];

    protected $presenter = \App\Presenters\ProductImagePresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\ProductImageObserver);
    }

    // Relations
    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id', 'id');
    }

    public function image()
    {
        return $this->belongsTo(\App\Models\Image::class, 'image_id', 'id');
    }



    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'image_id' => $this->image_id,
            'order' => $this->order,
        ];
    }

}
