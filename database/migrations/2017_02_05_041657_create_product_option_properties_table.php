<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateProductOptionPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_option_properties', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('product_option_id')->default(0);
            $table->bigInteger('property_value_id')->default(0);

            $table->timestamps();

            $table->index('id'); 
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
        Schema::dropIfExists('product_option_properties');
    }
}
