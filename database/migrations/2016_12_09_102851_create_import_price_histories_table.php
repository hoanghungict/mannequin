<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportPriceHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_price_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_option_id');
            $table->bigInteger('price');
            $table->bigInteger('creator_id');
            $table->text('notes')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->index('id', 'product_option_id');
        });

        DB::statement('ALTER TABLE import_price_histories MODIFY created_at '.'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');

        DB::statement('ALTER TABLE import_price_histories MODIFY updated_at '.'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('import_price_histories');
    }
}
