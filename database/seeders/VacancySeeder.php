<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vacancy;
use App\Models\Company;
use App\Enums\VacancyTypeEnum;
use App\Enums\IndustryEnum;

class VacancySeeder extends Seeder
{
    public function run()
    {
        // Assuming $companies are already loaded from the database
        $companies = Company::all();

        // Insert predefined vacancies
        Vacancy::create([
            "title" => "Senior Accounts Manager",
            'company_id' => $companies->firstWhere('company_name', "Foster's Finance")->id,
            "description" => "Manage and oversee accounts for top clients.",
            "skills_required" => "Accounting, Financial Analysis, Team Management",
            "application_open_date" => "2024-01-01",
            "application_close_date" => "2024-02-01",
            "industry" => IndustryEnum::Finance->value,
            "vacancy_type" => VacancyTypeEnum::FullTime->value,
            "reference_number" => "REF12345",
            "logo" => "public\company_logos\specific_logos\fosters_finance.png"
        ]);

        Vacancy::create([
            "title" => "Cybersecurity Analyst",
            'company_id' => $companies->firstWhere('company_name', 'Security Sloth')->id,
            "description" => "Monitor and prevent security breaches across systems.",
            "skills_required" => "Cybersecurity, Ethical Hacking, Risk Assessment",
            "application_open_date" => "2024-01-15",
            "application_close_date" => "2024-03-15",
            "industry" => IndustryEnum::InformationSecurity->value,
            "vacancy_type" => VacancyTypeEnum::FullTime->value,
            "reference_number" => "REF56789",
            "logo" => "public\company_logos\specific_logos\security_sloth.png"
        ]);

        Vacancy::create([
            "title" => "Product Design Intern",
            'company_id' => $companies->firstWhere('company_name', 'AtlasWare')->id,
            "description" => "Assist in designing new products for the tech market.",
            "skills_required" => "Graphic Design, UX/UI, Prototyping",
            "application_open_date" => "2024-02-01",
            "application_close_date" => "2024-03-01",
            "industry" => IndustryEnum::Technology->value,
            "vacancy_type" => VacancyTypeEnum::Internship->value,
            "reference_number" => "REF67890",
            "logo" => "public\company_logos\specific_logos\atlasware.png"
        ]);

        Vacancy::create([
            "title" => "Software Engineer",
            'company_id' => $companies->firstWhere('company_name', 'Tech Radar')->id,
            "description" => "Develop scalable software solutions for enterprise clients.",
            "skills_required" => "JavaScript, PHP, Laravel, API Integration",
            "application_open_date" => "2024-02-01",
            "application_close_date" => "2024-03-01",
            "industry" => IndustryEnum::Technology->value,
            "vacancy_type" => VacancyTypeEnum::FullTime->value,
            "reference_number" => "REF89012",
            "logo" => "public\company_logos\specific_logos\tech_radar.png"
        ]);
    }
}
