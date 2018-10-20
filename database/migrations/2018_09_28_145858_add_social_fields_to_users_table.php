<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSocialFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('twitter_id')->index();
            $table->integer('facebook_id')->index();
            $table->integer('linkedin_id')->index();
            $table->integer('google_id')->index();
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
            $table->dropColumn('twitter_id');
            $table->dropColumn('facebook_id');
            $table->dropColumn('linkedin_id');
            $table->dropColumn('google_id');
        });
    }
}
