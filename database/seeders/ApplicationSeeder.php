<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\User;
use App\Models\Vacancy;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a Faker instance for generating random data
        $faker = Faker::create();

        // Get a "fake current user"
        $user = User::first(); // Or create a fake user specifically

        // Get all vacancies from the Vacancy model
        $vacancies = Vacancy::all();

        // Applications for specific vacancies
        // For each vacancy, create several applications
        foreach ($vacancies as $vacancy) {
            // Create 3 fake applications for each specific vacancy
            for ($i = 0; $i < 3; $i++) {
                Application::create([
                    'name' => $faker->name, // Random name
                    'email' => $faker->unique()->safeEmail, // Random unique email
                    'mobile_number' => $faker->phoneNumber, // Random phone number
                    'supporting_statement' => $faker->paragraph, // Random supporting statement
                    'cv_path' => 'path/to/fake/cv' . $faker->numberBetween(1, 5) . '.pdf', // Fake CV file path
                    'vacancy_reference' => $vacancy->id, // Linking the application to the vacancy
                    'user_id' => $faker->numberBetween(1, 5), // Random user for variety
                ]);
            }
        }

        // Applications for the current user to other vacancies
        // The current user applies to 2 other vacancies (excluding their applied vacancies)
        $currentUserVacancies = $vacancies->pluck('id')->toArray(); // All vacancy IDs
        $currentUserVacanciesApplied = [];

        // Apply to 2 random vacancies for the current user
        for ($i = 0; $i < 2; $i++) {
            $randomVacancyId = $faker->randomElement($currentUserVacancies); // Pick a random vacancy
            while (in_array($randomVacancyId, $currentUserVacanciesApplied)) {
                $randomVacancyId = $faker->randomElement($currentUserVacancies); // Re-pick if already applied
            }

            // Store this as a vacancy the user has applied to
            $currentUserVacanciesApplied[] = $randomVacancyId;

            // Create the application for the current user
            Application::create([
                'name' => $user->name, // Use the current user's name
                'email' => $user->email, // Use the current user's email
                'mobile_number' => $user->mobile_number, // Use the current user's mobile number
                'supporting_statement' => 'I believe my skills align well with the job, and I would love to contribute.', // Custom supporting statement
                'cv_path' => 'path/to/fake/cv.pdf', // Static fake CV path
                'vacancy_reference' => $randomVacancyId, // Apply to the random vacancy
                'user_id' => $user->id, // Current user applying
            ]);
        }
    }
}
