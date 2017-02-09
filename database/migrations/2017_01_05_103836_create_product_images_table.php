<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateProductImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('product_id')->default(0)->index();
            $table->unsignedBigInteger('image_id')->default(0);
            $table->integer('order')->index();

            $table->softDeletes();
            $table->timestamps();

            $table->index(['product_id', 'order']);
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
        Schema::dropIfExists('product_images');
    }
}
