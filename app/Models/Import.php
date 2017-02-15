<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Import extends Base
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'imports';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'times',
        'notes',
        'total_amount',
        'employee_id',
        'creator_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['deleted_at'];

    protected $presenter = \App\Presenters\ImportPresenter::class;

    // Relations
    public function creator()
    {
        return $this->belongsTo( \App\Models\AdminUser::class, 'creator_id', 'id' );
    }

    public function details()
    {
        return $this->hasMany( \App\Models\ImportDetail::class, 'import_id', 'id');
    }

    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'           => $this->id,
            'times'        => $this->times,
            'total_amount' => $this->total_amount,
            'notes'        => $this->notes,
            'employee_id'  => $this->employee_id,
            'creator_id'   => $this->creator_id,
        ];
    }

}
