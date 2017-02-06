<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ExportPriceHistory extends Base {

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'export_price_histories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_option_id',
        'price',
        'creator_id',
        'notes',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['deleted_at'];

    protected $presenter = \App\Presenters\ExportPriceHistoryPresenter::class;

    // Relations
    public function productOption() {
        return $this->belongsTo( \App\Models\ProductOption::class, 'product_option_id', 'id' );
    }

    public function creator() {
        return $this->belongsTo( \App\Models\AdminUser::class, 'creator_id', 'id' );
    }



    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray() {
        return [
            'id'                => $this->id,
            'product_option_id' => $this->product_option_id,
            'price'             => $this->price,
            'creator_id'        => $this->creator_id,
            'notes'             => $this->notes,
        ];
    }

}
