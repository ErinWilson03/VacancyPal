<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
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
            'company_name' => $this->faker->company(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone_number' => $this->faker->phoneNumber(),
            'website' => $this->faker->domainName(),
            'logo' => $logoPath,
        ];

    }
}
