<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExportDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('export_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('export_id');
            $table->bigInteger('product_id');
            $table->bigInteger('option_id');

            $table->bigInteger('prices');
            $table->integer('quantity');
            $table->integer('unit_id');

            $table->softDeletes();
            $table->timestamps();

            $table->index('id', 'export_id');
        });

        DB::statement('ALTER TABLE export_details MODIFY created_at '.'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');

        DB::statement('ALTER TABLE export_details MODIFY updated_at '.'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('export_details');
    }
}
