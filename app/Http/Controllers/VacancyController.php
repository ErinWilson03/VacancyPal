<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacancy;
use App\Models\Company;
use App\Models\Application;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\File;
use \Illuminate\Support\Facades\Log;

class VacancyController
{

    // Helper method to generate a reference number for a vacancy
    public function generateReferenceNumber()
    {
        $randomNumber = mt_rand(1000, 9999);
        $prefix = 'VAC';

        $referenceNumber = $prefix . $randomNumber;

        // Ensure the reference number is unique in the database
        while (Vacancy::where('reference_number', $referenceNumber)->exists()) {
            $randomNumber = mt_rand(1000, 9999); // Generate a new number if the reference number already exists
            $referenceNumber = $prefix . $randomNumber;
        }

        return $referenceNumber;
    }

    // Display all vacancies
    public function index(Request $request)
    {
        // Get filtered and sorted vacancies using the helper method
        $vacancies = $this->filterVacancies($request);

        $size = $request->input('size', 10); // Default pagination size
        $sort = $request->input('sort', 'id'); // Default sorting
        $direction = $request->input('direction', 'asc'); // Default sort direction
        $search = $request->input('search', null); // Search term

        // Fetch the total number of vacancies after the filters
        $vacancyCount = $vacancies->total();

        // Get the current page and total pages for pagination
        $currentPage = $vacancies->currentPage();
        $totalPages = $vacancies->lastPage();

        // Add a deadline warning (if the closing date is within 3 days or passed)
        $vacancies->each(function ($vacancy) {
            $currentDate = now();
            $applicationDeadline = $vacancy->application_close_date;
            $vacancy->isDeadlineApproaching = $currentDate->diffInDays($applicationDeadline) <= 3;
            $vacancy->isDeadlinePassed = $currentDate->greaterThanOrEqualTo($applicationDeadline);
        });

        // Return the view with all necessary data
        return view('vacancies.index', [
            'vacancies' => $vacancies,
            'search' => $search,
            'vacancyCount' => $vacancyCount,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'size' => $size,
            // You could also pass additional filters like companies, industries, etc.
        ]);
    }


    // show the form to create a new vacancy
    public function create()
    {
        if (!Gate::allows('create', Vacancy::class)) {
            return redirect()->back()
                ->with('warning', 'Not authorised');
        }

        $vacancy = new Vacancy;
        $vacancy->rating = 0;
        $categories = Company::all()->pluck('name', 'id');

        return view('Vacancies.create', ['Vacancy' => $vacancy, 'categories' => $categories]);
    }

    // store a newly created vacancy
    public function store(Request $request){
        // Authorize the creation of a new vacancy
        Gate::authorize('create', Vacancy::class);
    
        // Validate incoming data, including the date validation rule
        $data = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'company_id' => ['required', 'exists:companies,id'],
            'company_name' => ['required', 'string', 'max:100'],
            'skills_required' => ['nullable', 'string'], // Skills required (can be a comma-separated string or array)
            'application_open_date' => ['required', 'date'],
            'application_close_date' => ['required', 'date', 'after:application_open_date'], // Ensuring close date is after open date
            'industry' => ['required', 'string', 'max:100'],
            'vacancy_type' => ['nullable', 'in:full-time,part-time,contract,temporary,internship'],
        ], [
            'company_id.required' => 'The Company field is required.',
            'company_id.exists' => 'The selected company does not exist.',
            'application_close_date.after' => 'The application close date must be later than the open date.',
        ]);
    
        // Generate the reference number (e.g., 'VAC1234')
        $referenceNumber = $this->generateReferenceNumber(); // Use the helper function from earlier
        $data['reference_number'] = $referenceNumber; // Assign the reference number to the data
    
        // Create the vacancy
        Vacancy::create($data);
    
        // Redirect to the vacancy index page
        return redirect()->route('vacancies.index')->with('success', 'Vacancy created successfully!');
    }
    

    // display a specific vacancy
    public function show(int $id)
    {
        //TODO: fix policy to allow admin and accountHolders to view vacancies
        // if (!Gate::allows('view', Vacancy::class)) {
        //     return redirect()->route('login')->with('info', 'Please Login to view a Vacancy');
        // }

        $vacancy = Vacancy::findOrFail($id);
        return view('vacancies.show', ['vacancy' => $vacancy]);
    }


    // show form for editing a specific vacancy
    public function edit(int $id)
    {
        if (!Gate::allows('update', Vacancy::class)) {
            return redirect()->route('login')->with('info', 'Please Login to edit a Vacancy');
        }

        $vacancy = Vacancy::findOrFail($id);
        $categories = Company::all()->pluck('name', 'id');

        return view('Vacancies.edit', ['Vacancy' => $vacancy, 'categories' => $categories]);
    }

    // update the vacancy
    public function update(Request $request, int $id)
    {
        // authorise the update
        Gate::authorize('update', Vacancy::class);

        $data = $request->validate([
            'title' => ['required', Rule::unique('Vacancies')->ignore($id)],
            'author' => ['required'],
            'Company_id' => ['required'],
            'year' => ['required', 'numeric'],
            'rating' => ['required', 'numeric', 'min:0', 'max:5'],
            'description' => ['min:0', 'max:500'],
            'image' => ['nullable', File::types(['png', 'jpg'])->max(1024)],
        ], ['Company_id' => 'The Company field is required']);

        if ($request->hasFile('image')) {
            $file = $request->image;
            // set validated data image field to base64 file content 
            $data['image'] = 'data:' . $file->getMimeType()
                . ';base64,'
                . base64_encode(file_get_contents($file));
        }

        $vacancy = Vacancy::findOrFail($id);
        $vacancy->update($data);

        return redirect()->route("Vacancies.show", $id);
    }

    // remove the vacancy
    public function destroy(int $id)
    {
        // authorise the deletion
        Gate::authorize('delete', Vacancy::class);

        $vacancy = Vacancy::findOrFail($id);
        $vacancy->delete();

        return redirect()->route("Vacancies.index");
    }

    private function filterVacancies(Request $request)
    {
        // Fetching filter parameters from the request
        $size = $request->input('size', 10);  // Pagination size
        $sort = $request->input('sort', 'id');  // Default sorting
        $direction = $request->input('direction', 'asc');  // Sort direction

        // Start the query for vacancies
        $vacancies = Vacancy::query();

        // Apply search filter if it exists
        if ($request->has('search')) {
            $search = $request->input('search');
            $vacancies = $vacancies->where('title', 'like', '%' . $search . '%');
        }

        // Apply industry filter if it exists
        if ($request->has('industry')) {
            $vacancies = $vacancies->where('industry', $request->input('industry'));
        }

        // Apply vacancy type filter if it exists
        if ($request->has('vacancy_type')) {
            $vacancies = $vacancies->where('vacancy_type', $request->input('vacancy_type'));
        }

        // Apply company filter if it exists (this assumes a 'company_id' filter)
        if ($request->has('company_id')) {
            $vacancies = $vacancies->where('company_id', $request->input('company_id'));
        }

        // Sorting the vacancies based on the user input
        $vacancies = $vacancies->orderBy($sort, $direction);

        // Paginate the results
        return $vacancies->paginate($size)->withQueryString();
    }


}
