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
        Schema::create('projects', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->string('name')->nullable();
            $table->uuid('created_by')->nullable();
            $table->uuid('owner_id');
            $table->timestamps();

            $table->index('id');
            $table->foreign('created_by')->references('id')
                ->on('users')->onDelete('set null');

            $table->foreign('owner_id')->references('id')
                ->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
