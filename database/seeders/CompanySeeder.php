<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\VacancyTypeEnum;
use App\Enums\IndustryEnum;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Predefined companies
        $c1 = Company::create([
            'company_name' => 'Tech Radar',
            'email' => 'contact@techradar.com',
            'phone_number' => '+1-800-555-TECH',
            'website' => 'https://www.techradar.com',
            "logo" => "public\company_logos\specific_logos\tech_radar.png"
        ]);

        $c2 = Company::create([
            'company_name' => 'Security Sloth',
            'email' => 'support@securitysloth.com',
            'phone_number' => '+1-800-555-SAFE',
            'website' => 'https://www.securitysloth.com',
            "logo" => "public\company_logos\specific_logos\securoty_sloth.png"
        ]);

        $c3 = Company::create([
            'company_name' => 'AtlasWare',
            'email' => 'info@atlasware.com',
            'phone_number' => '+1-800-555-GEAR',
            'website' => 'https://www.atlasware.com',
            "logo" => "public\company_logos\specific_logos\atlasware.png"
        ]);

        $c4 = Company::create([
            'company_name' => "Foster's Finance",
            'email' => 'finance@fosters.com',
            'phone_number' => '+1-800-555-MONEY',
            'website' => 'https://www.fostersfinance.com',
            "logo" => "public\company_logos\specific_logos\fosters_finance.png"
        ]);

        Company::factory(10)->create();
    }
}
