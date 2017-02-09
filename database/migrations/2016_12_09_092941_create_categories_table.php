<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->integer('order')->default(0);
            $table->text('notes')->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('categories');
    }
}
