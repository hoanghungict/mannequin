<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ImportDetail extends Base
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'import_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'import_id',
        'product_id',
        'option_id',
        'prices',
        'quantity',
        'unit_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['deleted_at'];

    protected $presenter = \App\Presenters\ImportDetailPresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\ImportDetailObserver);
    }

    // Relations
    public function import()
    {
        return $this->belongsTo( \App\Models\Import::class, 'import_id', 'id' );
    }

    public function product()
    {
        return $this->belongsTo( \App\Models\Product::class, 'product_id', 'id' );
    }

    public function productOption()
    {
        return $this->belongsTo( \App\Models\ProductOption::class, 'option_id', 'id' );
    }

    public function unit() {
        return $this->belongsTo( \App\Models\Unit::class, 'unit_id', 'id' );
    }


    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'                => $this->id,
            'import_id'         => $this->import_id,
            'product_id'        => $this->product_id,
            'option_id'         => $this->option_id,
            'prices'            => $this->prices,
            'quantity'          => $this->quantity,
            'unit_id'           => $this->unit_id,
        ];
    }

}
