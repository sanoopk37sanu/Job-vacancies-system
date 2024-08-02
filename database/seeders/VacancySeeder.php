<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VacancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    public function run(): void
    {
        $vacancies = [
            [
                'job_id' => 1,
                'status' => '1',
                'start_date' => '2024-08-21',
                'end_date' => '2024-08-22',
                'description' => 'Software Developer needed with 3 years of experience.',
            ],
            [
                'job_id' => 2,
                'status' => '1',
                'start_date' => '2024-08-25',
                'end_date' => '2024-08-26',
                'description' => 'Marketing Specialist required for a new campaign.',
            ],
            // Add more vacancy data here
        ];

        // Insert data into the vacancies table
        DB::table('vacancies')->insert($vacancies);
    }
}
