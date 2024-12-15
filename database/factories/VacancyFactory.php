<?php

namespace Database\Factories;

use App\Models\Vacancy;
use App\Models\Company;
use App\Enums\VacancyTypeEnum;
use App\Enums\IndustryEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VacancyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vacancy::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $applicationOpenDate = $this->faker->dateTimeBetween('now', '2025-12-31');
        $applicationCloseDate = $this->faker->dateTimeBetween($applicationOpenDate, '2025-12-31');

        return [
            'title' => $this->faker->jobTitle(),
            'company_id' => Company::factory(),
            'description' => $this->faker->sentence(),
            'skills_required' => implode(', ', $this->faker->words(5)),
            'application_open_date' => $applicationOpenDate->format('d-m-Y'),
            'application_close_date' => $applicationCloseDate->format('d-m-Y'),
            'industry' => $this->faker->randomElement(IndustryEnum::cases())->value,
            'vacancy_type' => $this->faker->randomElement(VacancyTypeEnum::cases())->value,
            'reference_number' => strtoupper(Str::random(10)),
        ];
    }
}
