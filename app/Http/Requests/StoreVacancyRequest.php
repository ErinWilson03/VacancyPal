<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\EnumIn;
use App\Enums\IndustryEnum;
use App\Enums\VacancyTypeEnum;

class StoreVacancyRequest extends FormRequest
{
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

    public function messages(): array
    {
        return [
            'company_id.required' => 'The Company field is required.',
            'industry.required' => 'Please select a valid industry',
            'vacancy_type.required' => 'Please select a valid vacancy type',
            'company_id.exists' => 'The selected company does not exist.',
            'application_close_date.after' => 'The application close date must be later than the open date.',
        ];
    }
}
