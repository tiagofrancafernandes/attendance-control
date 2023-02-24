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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->uuid('created_by')->nullable();
            $table->uuid('project_id');
            $table->json('tags')->nullable();
            $table->boolean('active')->nullable()->default(true);
            $table->timestamps();

            $table->index('id');
            $table->foreign('project_id')->references('id')
                ->on('projects')->onDelete('cascade');

            $table->foreign('created_by')->references('id')
                ->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaigns');
    }
};
