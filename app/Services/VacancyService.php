<?php

namespace App\Services;

use App\Models\Vacancy;
use App\Enums\IndustryEnum;
use App\Enums\VacancyTypeEnum;
use App\Models\Company;

class VacancyService
{
    public function createVacancy(array $data): Vacancy
    {
        $data['reference_number'] = $this->generateReferenceNumber();
        return Vacancy::create($data);
    }

    public function updateVacancy(Vacancy $vacancy, array $data): bool
    {
        return $vacancy->update($data);
    }

    private function generateReferenceNumber(): string
    {
        $maxAttempts = 10;
        $attempt = 0;

        // Preventing an edge case of an infinite loop
        do {
            $randomNumber = mt_rand(1000, 9999);
            $referenceNumber = 'VAC' + $randomNumber;
            $attempt++;
        } while (Vacancy::where('reference_number', $referenceNumber)->exists() && $attempt < $maxAttempts);

        if ($attempt >= $maxAttempts) {
            throw new \Exception('Failed to generate a unique reference number');
        }

        return $referenceNumber;
    }

    public function filterVacancies(array $filters, string $sort = 'application_close_date', string $direction = 'desc')
    {
        // Start building query for vacancies
        $query = Vacancy::with('company');

        // Apply filters
        if (!empty($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        if (!empty($filters['vacancy_type']) && $filters['vacancy_type'] !== 'all') {
            $query->where('vacancy_type', $filters['vacancy_type']);
        }

        if (!empty($filters['industry']) && $filters['industry'] !== 'all') {
            $query->where('industry', $filters['industry']);
        }

        // Apply sorting
        return $query->orderBy($sort, $direction);
    }

    public function addDeadlineWarnings($vacancies)
    {
        $vacancies->each(function ($vacancy) {
            $currentDate = now();
            $applicationDeadline = $vacancy->application_close_date;

            $vacancy->isDeadlineApproaching = $currentDate->lt($applicationDeadline) && $currentDate->diffInDays($applicationDeadline) <= 3;
            $vacancy->isDeadlinePassed = $currentDate->greaterThanOrEqualTo($applicationDeadline);
        });

        return $vacancies;
    }

    public function getDataForCreateForm()
    {
        return [
            'vacancy' => new Vacancy(),
            'industries' => IndustryEnum::cases(),
            'vacancyTypes' => VacancyTypeEnum::cases(),
            'companies' => Company::all()->pluck('company_name', 'id'),
        ];
    }

    public function getDataForEditForm(Vacancy $vacancy)
    {
        return [
            'vacancy' => $vacancy,
            'industries' => IndustryEnum::cases(),
            'vacancyTypes' => VacancyTypeEnum::cases(),
            'companies' => Company::all()->pluck('company_name', 'id'),
        ];
    }



}
