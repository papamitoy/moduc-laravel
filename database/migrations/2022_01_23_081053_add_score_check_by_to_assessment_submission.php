<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScoreCheckByToAssessmentSubmission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assessment_submissions', function (Blueprint $table) {

            $table->integer("score")->nullable();
            $table->boolean("status")->default(0);
            $table->bigInteger("checked_by")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assessment_submissions', function (Blueprint $table) {
            $table->dropColumn("score");
            $table->dropColumn("status");
            $table->dropColumn("checked_by");
        });
    }
}
