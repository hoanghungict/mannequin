<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateImportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imports', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->date('times');
            $table->bigInteger('total_amount')->default(0);
            $table->text('notes')->nullable();

            $table->string('employee_id')->default('[]');
            $table->bigInteger('creator_id')->default(0);

            $table->softDeletes();
            $table->timestamps();

            $table->index('id');
        });

        $this->updateTimestampDefaultValue('imports', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imports');
    }
}
