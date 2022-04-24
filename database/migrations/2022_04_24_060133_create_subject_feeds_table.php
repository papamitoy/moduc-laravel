<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_feeds', function (Blueprint $table) {
            $table->id();
            $table->integer("assessment_id");
            $table->integer("subject_id");
            $table->string("title");
            $table->text("body");
            $table->integer("owner");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subject_feeds');
    }
}
