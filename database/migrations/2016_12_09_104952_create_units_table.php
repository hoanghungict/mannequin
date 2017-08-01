<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->softDeletes();
            $table->timestamps();

            $table->index('id');
        });

        $this->updateTimestampDefaultValue('units', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
    }
}
