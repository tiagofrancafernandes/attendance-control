<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Campaign;
use Illuminate\Database\Seeder;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Project::factory(10)->create()->each(
            fn (Project $project) => Campaign::factory(
                rand(2, 5),
                [
                    'project_id' => $project->id,
                ]
            )->create()
        );
    }
}
