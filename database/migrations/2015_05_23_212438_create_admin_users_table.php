<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->string('email');
            $table->string('password', 60);

            $table->string('locale')->default('');

            $table->bigInteger('last_notification_id')->default(0);

            $table->string('api_access_token')->default('');

            $table->unsignedBigInteger('profile_image_id')->default(0);

            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE admin_users MODIFY created_at '.'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');

        DB::statement('ALTER TABLE admin_users MODIFY updated_at '.'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('admin_users');
    }
}
