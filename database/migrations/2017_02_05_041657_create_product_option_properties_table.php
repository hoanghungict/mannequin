<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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

        DB::statement("ALTER TABLE product_option_properties MODIFY created_at " . "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");

        DB::statement("ALTER TABLE product_option_properties MODIFY updated_at " . "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
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
