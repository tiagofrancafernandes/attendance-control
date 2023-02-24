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
        Schema::create('survey_answers', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->uuid('survey_id');
            $table->uuid('campaign_id')->nullable();
            $table->json('answer_data');
            $table->string('responder_identifier_01')->nullable(); // Way to identify the responder
            $table->string('responder_identifier_02')->nullable(); // Way to identify the responder
            $table->timestamps();

            $table->index('id');
            $table->index('survey_id');

            $table->foreign('survey_id')->references('id')
                ->on('surveys')->onDelete('cascade'); //cascade|set null

            $table->foreign('campaign_id')->references('id')
                ->on('campaigns')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_answers');
    }
};
