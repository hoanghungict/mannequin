<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyValue extends Base 
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'property_values';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'property_id',
        'value',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['deleted_at'];

    protected $presenter = \App\Presenters\PropertyValuePresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\PropertyValueObserver);
    }

    // Relations
    public function property() 
    {
        return $this->belongsTo( \App\Models\Property::class, 'property_id', 'id' );
    }


    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray() 
    {
        return [
            'id'          => $this->id,
            'property_id' => $this->property_id,
            'value'       => $this->value,
        ];
    }

}
