<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Survey;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Project::factory(10)->create()->each(
            fn (Project $project) => Survey::factory(
                2,
                [
                    'project_id' => $project->id,
                ]
            )->create()
        );
    }
}
