<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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

        DB::statement('ALTER TABLE product_images MODIFY created_at '.'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');

        DB::statement('ALTER TABLE product_images MODIFY updated_at '.'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
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
