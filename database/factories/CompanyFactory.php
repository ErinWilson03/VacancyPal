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
        // Set the path to the folder containing logos inside the public directory
        $logosDirectory = public_path('company_logos');

        // Get all files from the company_logos folder
        $logos = File::allFiles($logosDirectory);

        // Select a random logo file
        $randomLogo = $this->faker->randomElement($logos);

        // Generate the relative path for the logo
        $logoPath = 'company_logos/' . basename($randomLogo);

        return [
            'company_name' => $this->faker->company(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone_number' => $this->faker->phoneNumber(),
            'website' => $this->faker->domainName(),
            'logo' => $logoPath, // This will store the relative path
        ];
    }
}
