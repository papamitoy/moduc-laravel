<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropMaxScoreToMainAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('main_assessments', function (Blueprint $table) {
            $table->dropColumn("max_score");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('main_assessments', function (Blueprint $table) {
            $table->integer("max_score")->default(10)->after("questions");
            //
        });
    }
}
