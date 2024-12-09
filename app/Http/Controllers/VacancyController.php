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
        // Causing problems right now 

        // if (!Gate::allows('viewAny', Vacancy::class)) {

        //     return redirect()->route('login')->with('info', 'Please Login to view Vacancies');
        // }

        $size = $request->input('size', 10);
        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'asc');

        $search = $request->input('search', null);

        // // TBC implement pagination and sorting
        $vacancies = Vacancy::with(['company']) // captial C ?
            ->search($search)
            ->sortable($sort, $direction)
            ->paginate($size)
            ->withQueryString();

        return view('vacancies.index', ['vacancies' => $vacancies, 'search' => $search]);
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
    public function store(Request $request)
    {
        // Authorize the creation of a new vacancy
        Gate::authorize('create', Vacancy::class);
    
        // Validate incoming data
        $data = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'company_id' => ['required', 'exists:companies,id'],
            'company_name' => ['required', 'string', 'max:100'],
            'skills_required' => ['nullable', 'string'], // Skills required (can be a comma-separated string or array)
            'application_open_date' => ['required', 'date'],
            'application_close_date' => ['required', 'date'],
            'industry' => ['required', 'string', 'max:100'],
            'vacancy_type' => ['nullable', 'in:full-time,part-time,contract,temporary,internship'], // Vacancy types
            'logo' => ['nullable', 'file', 'mimes:png,jpg', 'max:1024'], // File validation for the logo image
        ], [
            'company_id.required' => 'The Company field is required.',
            'company_id.exists' => 'The selected company does not exist.',
        ]);
    
        // Handle the logo file if present
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $logoPath = $file->store('vacancies/logos', 'public'); // Store the file in the public disk
            $data['logo'] = $logoPath; // Save the file path
        }
    
        // Generate the reference number (e.g., 'VAC1234')
        $referenceNumber = $this->generateReferenceNumber(); // Use the helper function from earlier
        $data['reference_number'] = $referenceNumber; // Assign the reference number to the data
    
        // Create the vacancy
        Vacancy::create($data);
    
        // Redirect to the vacancy index page
        return redirect()->route('vacancies.index');
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
}
