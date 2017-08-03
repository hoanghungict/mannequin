<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

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
            $table->integer('unit_exchange')->default(1);

            $table->softDeletes();
            $table->timestamps();

            $table->index(['id', 'export_id']);
        });

        $this->updateTimestampDefaultValue('export_details', ['updated_at'], ['created_at']);

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
