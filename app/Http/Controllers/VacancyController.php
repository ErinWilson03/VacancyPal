<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use App\Models\Company;
use App\Services\VacancyService;
use App\Http\Requests\StoreVacancyRequest;
use App\Http\Requests\UpdateVacancyRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use app\Enums\VacancyTypeEnum;
use app\Enums\IndustryEnum;

class VacancyController extends Controller
{
    protected $vacancyService;

    public function __construct(VacancyService $vacancyService)
    {
        $this->vacancyService = $vacancyService;
    }

    public function index(Request $request)
    {
        // Get the pagination size, defaulting to 10 if not provided
        $size = $request->input('size', 10);
        $search = $request->input('search', null);

        // Prepare filters and sorting parameters
        $filters = [
            'search' => $search,
            'vacancy_type' => $request->input('vacancy_type'),
            'industry' => $request->input('industry'),
        ];
        $sort = $request->input('sort', 'application_close_date');
        $direction = $request->input('direction', 'desc');

        $vacancies = $this->vacancyService->filterVacancies($filters, $sort, $direction)
            ->paginate($size)
            ->withQueryString();

        $vacancies = $this->vacancyService->addDeadlineWarnings($vacancies);


        // Return the view with necessary data
        return view('vacancies.index', [
            'vacancies' => $vacancies,
            'search' => $search,
            'vacancyCount' => $vacancies->total(),
            'currentPage' => $vacancies->currentPage(),
            'totalPages' => $vacancies->lastPage(),
            'size' => $size,
        ]);
    }


    // display a specific vacancy
    public function show(int $id)
    {
        if (!Gate::allows('view', Vacancy::class)) {
            return redirect()->route('login')->with('info', 'Please Login to view a Vacancy');
        }

        $vacancy = Vacancy::findOrFail($id);
        return view('vacancies.show', ['vacancy' => $vacancy]);
    }

    public function create()
    {
        Gate::authorize('create', Vacancy::class);

        $data = $this->vacancyService->getDataForCreateForm();

        return view('vacancies.create', $data);

    }

    public function store(StoreVacancyRequest $request)
    {
        Gate::authorize('create', Vacancy::class);

        $this->vacancyService->createVacancy($request->validated());

        return redirect()->route('vacancies.index')->with('success', 'Vacancy created successfully!');
    }

    public function edit(Vacancy $vacancy)
    {
        Gate::authorize('update', $vacancy);

        $data = $this->vacancyService->getDataForEditForm($vacancy);
        return view('vacancies.edit', $data);
    }

    public function update(UpdateVacancyRequest $request, Vacancy $vacancy)
    {
        Gate::authorize('update', $vacancy);

        $this->vacancyService->updateVacancy($vacancy, $request->validated());

        return redirect()->route('vacancies.show', $vacancy->id)->with('success', 'Vacancy updated successfully!');
    }

    public function destroy(Vacancy $vacancy)
    {
        Gate::authorize('delete', $vacancy);

        $vacancy->delete();

        return redirect()->route('vacancies.index')->with('info', 'Vacancy deleted');
    }
}
