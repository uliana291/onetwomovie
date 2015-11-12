<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProfileInfoToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('last_name');
            $table->date('birth_date');
            $table->enum('status', ['enable', 'disable']);
            $table->integer('city_id');
            $table->text('about');
            $table->string('mobile_number');
            $table->string('skype');
            $table->string('vk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['last_name', 'birth_date', 'status',
                'city_id', 'about', 'mobile_number', 'skype', 'vk']);
        });
    }
}
