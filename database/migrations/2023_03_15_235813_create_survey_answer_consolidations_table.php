<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_answer_consolidations', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->uuid('survey_id');
            $table->json('report_data');
            $table->timestamps();

            $table->index('id');
            $table->index('survey_id');

            $table->foreign('survey_id')->references('id')
                ->on('surveys')->onDelete('cascade'); //cascade|set null
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_answer_consolidations');
    }
};
