<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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

        DB::statement("ALTER TABLE categories MODIFY created_at " .
            "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");

        DB::statement("ALTER TABLE categories MODIFY updated_at " .
            "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
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
