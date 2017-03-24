<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Base
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'employees';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'telephone',
        'province_id',
        'district_id',
        'avatar_image_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates  = ['deleted_at'];

    protected $presenter = \App\Presenters\EmployeePresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\EmployeeObserver);
    }

    // Relations
    public function province()
    {
        return $this->belongsTo(\App\Models\Province::class, 'province_id', 'id');
    }

    public function district()
    {
        return $this->belongsTo(\App\Models\District::class, 'district_id', 'id');
    }

    public function avatarImage()
    {
        return $this->hasOne(\App\Models\Image::class, 'id', 'avatar_image_id');
    }



    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'telephone' => $this->telephone,
            'province_id' => $this->province_id,
            'district_id' => $this->district_id,
            'avatar_image_id' => $this->avatar_image_id,
        ];
    }

}
