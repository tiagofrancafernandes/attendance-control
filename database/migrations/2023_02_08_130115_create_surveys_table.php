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
        Schema::create('surveys', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->uuid('created_by')->nullable();
            $table->uuid('project_id');
            $table->boolean('active')->nullable()->default(true);
            $table->boolean('published')->nullable()->default(false);
            $table->datetime('will_start_in')->nullable();
            $table->datetime('will_finish_in')->nullable();
            $table->timestamps();

            $table->index('id');
            $table->foreign('project_id')->references('id')
                ->on('projects')->onDelete('cascade'); //cascade|set null

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
        Schema::dropIfExists('surveys');
    }
};
