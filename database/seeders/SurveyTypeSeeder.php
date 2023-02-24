<?php

namespace Database\Seeders;

use App\Models\SurveyType;
use Illuminate\Database\Seeder;

class SurveyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SurveyType::factory(10)->create();
    }
}
