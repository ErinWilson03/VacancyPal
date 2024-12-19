<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\EnumIn;
use App\Enums\IndustryEnum;
use App\Enums\VacancyTypeEnum;

class UpdateVacancyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authorization logic if needed
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:100'],
            'company_id' => ['required', 'exists:companies,id'],
            'skills_required' => ['nullable', 'string'],
            'application_open_date' => ['required', 'date'],
            'application_close_date' => ['required', 'date', 'after:application_open_date'],
            'industry' => ['required', new EnumIn(IndustryEnum::class)],
            'vacancy_type' => ['required', new EnumIn(VacancyTypeEnum::class)],
        ];
    }
}
