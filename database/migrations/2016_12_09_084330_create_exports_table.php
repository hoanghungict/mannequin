<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateExportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employee_id')->default('[]');
            $table->integer('customer_id');
            $table->integer('store_id');

            $table->date('times');

            $table->bigInteger('discount')->default(0);
            $table->string('discount_unit')->default('%');
            $table->bigInteger('total_amount')->default(0);

            $table->text('notes')->nullable();

            $table->bigInteger('creator_id')->default(0);

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
        Schema::dropIfExists('exports');
    }
}
