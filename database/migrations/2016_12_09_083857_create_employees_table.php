<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address');
            $table->string('telephone');
            $table->integer('province_id')->default(0);
            $table->integer('district_id')->default(0);
            $table->bigInteger('avatar_image_id')->default(0);

            $table->softDeletes();
            $table->timestamps();

            $table->index(['id', 'name']);
        });

        $this->updateTimestampDefaultValue('employees', ['updated_at'], ['created_at']);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
