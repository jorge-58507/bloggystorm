<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserToPost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bs_posts', function ($table) {
            $table->string('post_ai_user_id')->after('tx_post_content');
            $table->string('tx_post_date')->after('tx_post_title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bs_posts', function ($table) {
            $table->dropColumn('post_ai_user_id');
            $table->dropColumn('tx_post_date');
        });
    }
}
