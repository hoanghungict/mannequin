<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Export extends Base 
{
    const TYPE_DISCOUNT_PERCENT = '%';
    const TYPE_DISCOUNT_VND     = 'vnd';

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'exports';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'customer_id',
        'store_id',
        'times',
        'discount',
        'discount_unit',
        'total_amount',
        'notes',
        'creator_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['deleted_at'];

    protected $presenter = \App\Presenters\ExportPresenter::class;

    // Relations
    public function employee() 
    {
        return $this->belongsTo( \App\Models\Employee::class, 'employee_id', 'id' );
    }

    public function customer() 
    {
        return $this->belongsTo( \App\Models\Customer::class, 'customer_id', 'id' );
    }

    public function store() 
    {
        return $this->belongsTo( \App\Models\Store::class, 'store_id', 'id' );
    }

    public function creator() 
    {
        return $this->belongsTo( \App\Models\AdminUser::class, 'creator_id', 'id' );
    }



    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray() 
    {
        return [
            'id'            => $this->id,
            'employee_id'   => $this->employee_id,
            'customer_id'   => $this->customer_id,
            'store_id'      => $this->store_id,
            'times'         => $this->times,
            'discount'      => $this->discount,
            'discount_unit' => $this->discount_unit,
            'total_amount'  => $this->total_amount,
            'notes'         => $this->notes,
            'creator_id'    => $this->creator_id,
        ];
    }

}
