<?php

namespace Database\Factories;

use App\Models\Vacancy;
use App\Models\Company;
use App\Enums\VacancyTypeEnum;
use App\Enums\IndustryEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class VacancyFactory extends Factory
{
    protected $model = Vacancy::class;

    public function definition(): array
    {
        // Generate realistic future dates
        $applicationOpenDate = Carbon::now()->addDays(rand(1, 30)); // Open within the next 30 days
        $applicationCloseDate = $applicationOpenDate->copy()->addMonths(rand(1, 3)); // Close within 1 to 3 months after open

        // Use ucwords to ensure title is in proper case
        $title = ucwords($this->faker->jobTitle());
        
        return [
            'title' => $title,
            'company_id' => Company::factory(),
            'description' => $this->faker->sentence(),
            'skills_required' => implode(', ', $this->faker->words(5)),
            'application_open_date' => $applicationOpenDate->format('Y-m-d H:i:s'),
            'application_close_date' => $applicationCloseDate->format('Y-m-d H:i:s'),
            'industry' => $this->faker->randomElement(IndustryEnum::cases())->value,
            'vacancy_type' => $this->faker->randomElement(VacancyTypeEnum::cases())->value,
            'reference_number' => strtoupper(Str::random(10)),
        ];
    }
}
