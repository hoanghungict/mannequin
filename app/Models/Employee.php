<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Base {

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
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['deleted_at'];

    //    protected $presenter = \App\Presenters\EmployeePresenter::class;

    // Relations
    /*
     * API Presentation
     */
    public function toAPIArray() {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'address'   => $this->address,
            'telephone' => $this->telephone,
        ];
    }

}
