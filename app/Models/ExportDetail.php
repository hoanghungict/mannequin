<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ExportDetail extends Base
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'export_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'export_id',
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

    protected $presenter = \App\Presenters\ExportDetailPresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\ExportDetailObserver);
    }

    // Relations
    public function export()
    {
        return $this->belongsTo( \App\Models\Export::class, 'export_id', 'id' );
    }

    public function product()
    {
        return $this->belongsTo( \App\Models\Product::class, 'product_id', 'id' );
    }

    public function productOption()
    {
        return $this->belongsTo( \App\Models\ProductOption::class, 'option_id', 'id' );
    }

    public function unit()
    {
        return $this->belongsTo( \App\Models\Unit::class, 'unit_id', 'id' );
    }



    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'         => $this->id,
            'export_id'  => $this->export_id,
            'product_id' => $this->product_id,
            'option_id'  => $this->option_id,
            'prices'     => $this->prices,
            'quantity'   => $this->quantity,
            'unit_id'    => $this->unit_id,
        ];
    }

}
