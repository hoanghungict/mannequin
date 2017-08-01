<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('name');
            $table->integer('subcategory_id');
            $table->integer('unit_id');
            $table->integer('unit2_id')->default(0);
            $table->integer('unit_exchange')->default(0);
            $table->text('descriptions')->nullable();
            $table->integer('is_enabled')->default(1);

            $table->softDeletes();
            $table->timestamps();

            $table->index('id');
        });

        $this->updateTimestampDefaultValue('products', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
