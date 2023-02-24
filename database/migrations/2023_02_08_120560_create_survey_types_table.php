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
        Schema::create('survey_types', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->string('title'); // NPS, Feedback, etc
            $table->string('initial_template')->nullable(); // json_file:schema_01.json | php_config:schema_01.php | json:{...}
            $table->uuid('project_id')->nullable();         // If null, the template can be global
            $table->boolean('is_global')->default(false);   // Global can be listed by anyone (project_id must be null)
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('project_id')->references('id')
                ->on('projects')->onDelete('cascade'); //cascade|set null
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_types');
    }
};
