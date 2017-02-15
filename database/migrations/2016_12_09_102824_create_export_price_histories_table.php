<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateExportPriceHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('export_price_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_id');
            $table->bigInteger('product_option_id');
            $table->bigInteger('price');
            $table->bigInteger('creator_id');
            $table->text('notes')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->index(['id', 'product_option_id']);
        });

        $this->updateTimestampDefaultValue('users', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('export_price_histories');
    }
}
