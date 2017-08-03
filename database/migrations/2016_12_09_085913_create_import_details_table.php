<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

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
            $table->bigInteger('option_id');

            $table->bigInteger('prices');
            $table->integer('quantity');
            $table->integer('unit_id');
            $table->integer('unit_exchange')->default(1);

            $table->softDeletes();
            $table->timestamps();

            $table->index(['id', 'import_id']);
        });

        $this->updateTimestampDefaultValue('import_details', ['updated_at'], ['created_at']);

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
