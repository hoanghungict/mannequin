<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address');
            $table->string('telephone');
            $table->integer('province_id')->default(0);
            $table->integer('district_id')->default(0);
            $table->bigInteger('avatar_image_id')->nullable()->default(0);

            $table->softDeletes();
            $table->timestamps();

            $table->index(['id', 'name']);
        });

        $this->updateTimestampDefaultValue('customers', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
