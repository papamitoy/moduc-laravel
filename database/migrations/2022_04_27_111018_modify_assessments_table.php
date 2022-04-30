<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("assessments",function(Blueprint $table){
            $table->integer("main_assessment_id")->after("deadline");
            $table->boolean("has_time_limit")->default(false)->after("deadline");
            $table->string("time_limit")->nullable()->after("deadline");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("assessments",function(Blueprint $table){
            $table->dropColumn("main_assessment_id");
            $table->dropColumn("has_time_limit");
            $table->dropColumn("time_limit");
        });
    }
}
