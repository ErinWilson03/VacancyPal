<?php

namespace Database\Factories;

use App\Models\Vacancy;
use App\Models\Company;
use App\Enums\VacancyTypeEnum;
use App\Enums\IndustryEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

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
        // Randomly selecting a logo and assigning its path
        $logos = File::allFiles(storage_path('app\public\company_logos'));
        $randomLogo = $this->faker->randomElement($logos);
        $logoPath = 'app\public\company_logos/' . basename($randomLogo);

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
            'logo' => $logoPath,
        ];
    }
}
