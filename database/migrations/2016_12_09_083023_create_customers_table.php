<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigInteger('avatar_image_id')->default(0);

            $table->softDeletes();
            $table->timestamps();

            $table->index('id', 'name');
        });

        DB::statement('ALTER TABLE customers MODIFY created_at '.'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');

        DB::statement('ALTER TABLE customers MODIFY updated_at '.'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
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
