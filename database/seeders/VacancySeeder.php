<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vacancy;
use App\Models\Company;
use App\Enums\VacancyTypeEnum;
use App\Enums\IndustryEnum;
use App\Enums\LocationEnum;
use Carbon\Carbon;

class VacancySeeder extends Seeder
{
    public function run()
    {
        $companies = Company::all();

        // Generating a date to ensure the 'closing soon' flag appears for at least one vacancy
        $flagOpeningDate = Carbon::now(); // Open date is 'today'
        $flagClosingDate = Carbon::now()->addDays(2); // Closes in two days

        // Hard coding a vacancy which has already closed
        Vacancy::create([
            "title" => "Senior Accounts Manager",
            'company_id' => $companies->firstWhere('company_name', "Foster's Finance")->id,
            "description" => "Manage and oversee accounts for top clients.",
            "skills_required" => "Accounting, Financial Analysis, Team Management",
            "application_open_date" => Carbon::createFromFormat('d-m-Y', "01-01-2025"),
            "application_close_date" => Carbon::createFromFormat('d-m-Y', "20-04-2025"),
            "location" => LocationEnum::InOffice->value,
            "salary"=> "70,000",
            "industry" => IndustryEnum::Finance->value,
            "vacancy_type" => VacancyTypeEnum::FullTime->value,
            "reference_number" => "REF12345",
        ]);

        Vacancy::create([
            "title" => "Cybersecurity Analyst",
            'company_id' => $companies->firstWhere('company_name', 'Security Sloth')->id,
            "description" => "Monitor and prevent security breaches across systems.",
            "skills_required" => "Cybersecurity, Ethical Hacking, Risk Assessment",
            "application_open_date" => Carbon::createFromFormat('d-m-Y', "10-12-2024"),
            "application_close_date" => Carbon::createFromFormat('d-m-Y', "08-02-2025"),
            "location" => LocationEnum::Hybrid->value,
            "salary"=> "60,000",
            "industry" => IndustryEnum::InformationSecurity->value,
            "vacancy_type" => VacancyTypeEnum::FullTime->value,
            "reference_number" => "REF56789",
        ]);

        // Hard coding a vacancy which should be 'closing soon'
        Vacancy::create([
            "title" => "Product Design Intern",
            'company_id' => $companies->firstWhere('company_name', 'AtlasWare')->id,
            "description" => "Assist in designing new products for the tech market.",
            "skills_required" => "Graphic Design, UX/UI, Prototyping",
            // TODO: double check this logic
            'application_open_date' => $flagOpeningDate->format('Y-m-d H:i:s'),
            "application_close_date" => $flagClosingDate->format('Y-m-d H:i:s'),
            "location" => LocationEnum::InOffice->value,
            "salary"=> "20,000",
            "industry" => IndustryEnum::Technology->value,
            "vacancy_type" => VacancyTypeEnum::Internship->value,
            "reference_number" => "REF67890",
        ]);

        Vacancy::create([
            "title" => "Software Engineer",
            'company_id' => $companies->firstWhere('company_name', 'Tech Radar')->id,
            "description" => "Develop scalable software solutions for enterprise clients.",
            "skills_required" => "JavaScript, PHP, Laravel, API Integration",
            // hard coding a deadline in the past to allow the deadline flag to appear         
            "application_open_date" => Carbon::createFromFormat('d-m-Y', "01-12-2024"),
            "application_close_date" => Carbon::createFromFormat('d-m-Y', "02-12-2024"),
            "location" => LocationEnum::Remote->value,
            "salary"=> "40,000",
            "industry" => IndustryEnum::Technology->value,
            "vacancy_type" => VacancyTypeEnum::FullTime->value,
            "reference_number" => "REF89012",
        ]);
    }
}
