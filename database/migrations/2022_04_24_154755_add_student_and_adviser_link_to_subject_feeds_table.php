<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStudentAndAdviserLinkToSubjectFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subject_feeds', function (Blueprint $table) {
            $table->text("student_link")->after("body");
            $table->text("adviser_link")->after("body");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subject_feeds', function (Blueprint $table) {
            $table->dropColumn("student_link");
            $table->dropColumn("adviser_link");
        });
    }
}
