<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $notProductionSeeders = [
            ProjectSeeder::class,
            SurveyTypeSeeder::class,
            // SurveySeeder::class,
            CampaignSeeder::class,
            // SurveyAnswerSeeder::class,
            SurveyAnswerConsolidationSeeder::class,
        ];

        if (!app()->environment(['production'])) {
            foreach ($notProductionSeeders as $seeder) {
                $this->call($seeder);
            }
        }
    }
}
