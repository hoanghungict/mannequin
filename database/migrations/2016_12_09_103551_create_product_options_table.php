<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateProductOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_id');
            $table->bigInteger('import_price');
            $table->bigInteger('export_price');
            $table->integer('quantity');
            $table->integer('is_enabled')->default(1);

            $table->softDeletes();
            $table->timestamps();

            $table->index(['id', 'product_id']);
        });

        $this->updateTimestampDefaultValue('product_options', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_options');
    }
}
