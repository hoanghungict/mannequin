<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;


class Subcategory extends Base
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subcategories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'order',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates  = ['deleted_at'];

    protected $presenter = \App\Presenters\SubcategoryPresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\SubcategoryObserver);
    }

    // Relations
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product', 'subcategory_id', 'id');
    }

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'          => $this->id,
            'category_id' => $this->category_id,
            'name'        => $this->name,
            'slug'        => $this->slug,
            'order'       => $this->order,
        ];
    }

}
