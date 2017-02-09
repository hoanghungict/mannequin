<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcategories', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('category_id')->default(0);

            $table->string('name')->default('');

            $table->string('slug')->default('');

            $table->integer('order')->default(0)->index();

            $table->softDeletes();
            $table->timestamps();
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
        Schema::drop('subcategories');
    }
}
