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
        return [
            'title' => $this->faker->jobTitle(),
            'company_id' => Company::factory(),
            'description' => $this->faker->sentence(),
            'skills_required' => $this->faker->words(5, true),
            'application_open_date' => $this->faker->date(),
            'application_close_date' => $this->faker->date(),
            'industry' => $this->faker->randomElement(IndustryEnum::cases())->value,
            'vacancy_type' => $this->faker->randomElement(VacancyTypeEnum::cases())->value,
            'reference_number' => strtoupper(Str::random(10)),
        ];
    }
}
