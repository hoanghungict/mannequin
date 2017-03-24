<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Base 
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'properties';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['deleted_at'];

    protected $presenter = \App\Presenters\PropertyPresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\PropertyObserver);
    }

    // Relations
    public function propertyValues() 
    {
        return $this->hasMany( 'App\Models\PropertyValue', 'property_id', 'id' );
    }

    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray() 
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
        ];
    }

}
