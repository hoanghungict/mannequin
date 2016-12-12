<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('import_id');
            $table->bigInteger('product_id');
            $table->string('property_value_id');

            $table->bigInteger('prices');
            $table->integer('quantity');
            $table->integer('unit_id');

            $table->softDeletes();
            $table->timestamps();

            $table->index('id', 'import_id');
        });

        DB::statement('ALTER TABLE import_details MODIFY created_at '.'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');

        DB::statement('ALTER TABLE import_details MODIFY updated_at '.'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('import_details');
    }
}
