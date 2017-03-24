<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Base
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'order',
        'notes',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['deleted_at'];

    protected $presenter = \App\Presenters\CategoryPresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\CategoryObserver);
    }

    // Relations
    public function subcategories()
    {
        return $this->hasMany('App\Models\Subcategory', 'category_id', 'id')->orderBy('order', 'asc');
    }

    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'    => $this->id,
            'name'  => $this->getLocalizedColumn('name'),
            'slug'  => $this->slug,
            'order' => $this->order,
            'notes' => $this->notes,
        ];
    }

}
