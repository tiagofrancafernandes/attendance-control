<?php

namespace Database\Seeders;

use App\Models\SurveyAnswer;
use Illuminate\Database\Seeder;

class SurveyAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SurveyAnswer::factory(10)->create();
    }
}
