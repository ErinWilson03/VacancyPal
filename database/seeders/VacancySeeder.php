<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vacancy;
use App\Models\Company;
use App\Enums\VacancyTypeEnum;
use App\Enums\IndustryEnum;
use Carbon\Carbon;

class VacancySeeder extends Seeder
{
    public function run()
    {
        $companies = Company::all();

        Vacancy::create([
            "title" => "Senior Accounts Manager",
            'company_id' => $companies->firstWhere('company_name', "Foster's Finance")->id,
            "description" => "Manage and oversee accounts for top clients.",
            "skills_required" => "Accounting, Financial Analysis, Team Management",
            "application_open_date" => Carbon::createFromFormat('d-m-Y', "01-01-2025"),
            "application_close_date" => Carbon::createFromFormat('d-m-Y', "20-04-2025"),
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
            "industry" => IndustryEnum::InformationSecurity->value,
            "vacancy_type" => VacancyTypeEnum::FullTime->value,
            "reference_number" => "REF56789",
        ]);

        Vacancy::create([
            "title" => "Product Design Intern",
            'company_id' => $companies->firstWhere('company_name', 'AtlasWare')->id,
            "description" => "Assist in designing new products for the tech market.",
            "skills_required" => "Graphic Design, UX/UI, Prototyping",
            // TODO: before submission, change this to be a date very soon after submission
            "application_open_date" => Carbon::createFromFormat('d-m-Y', "01-12-2024"),
            "application_close_date" => Carbon::createFromFormat('d-m-Y', "16-12-2024"),
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
            "industry" => IndustryEnum::Technology->value,
            "vacancy_type" => VacancyTypeEnum::FullTime->value,
            "reference_number" => "REF89012",
        ]);
    }
}
