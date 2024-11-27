<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ApplicationController extends Controller
{
    // Display all applications (admin or HR view)
    public function index(Request $request)
    {
        if (!Gate::allows('viewAny', Application::class)) {
            return redirect()->route('login')->with('info', 'Please Login to view Applications');
        }

        $size = $request->input('size', 10);
        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'asc');
        $search = $request->input('search', null);

        $applications = Application::with('vacancy') // Include vacancy details in the query
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
            })
            ->sortable($sort, $direction)
            ->paginate($size)
            ->withQueryString();

        return view('applications.index', ['applications' => $applications, 'search' => $search]);
    }

    // Show the form to create a new application for a specific vacancy
    public function create($vacancyId)
    {
        $vacancy = Vacancy::findOrFail($vacancyId);

        // TODO: reevaluate the auth logic for this
        // if (!Gate::allows('apply', $vacancy)) {
        //     return redirect()->route('vacancies.index')->with('warning', 'You are not authorized to apply for this vacancy.');
        // }

        return view('applications.create', ['vacancy' => $vacancy]);
    }

    // Store a newly created application
    public function store(Request $request)
    {
        // Authorize the creation of an application
        Gate::authorize('apply', Application::class);

        // Validate the incoming request
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:applications,email'],
            'mobile_number' => ['required', 'string', 'min:10'],
            'supporting_statement' => ['nullable', 'string', 'max:1000'],
            'cv' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:2048'], // CV file validation
            'vacancy_id' => ['required', 'exists:vacancies,id'], // Make sure vacancy exists
        ]);

        // Handle CV file upload
        if ($request->hasFile('cv')) {
            $cvFile = $request->file('cv');
            $cvPath = $cvFile->store('applications/cvs', 'public'); // Store the file in the public disk
            $data['cv_path'] = $cvPath; // Save the file path in the database
        }

        // Create the application record in the database
        Application::create($data);

        // Redirect to the application index or the vacancy page
        return redirect()->route('vacancies.index')->with('success', 'Your application has been submitted successfully!');
    }

    // Show a specific application details
    public function show($id)
    {
        if (!Gate::allows('view', Application::class)) {
            return redirect()->route('login')->with('info', 'Please Login to view an Application');
        }

        $application = Application::with('vacancy')->findOrFail($id);
        return view('applications.show', ['application' => $application]);
    }

    // Show form for editing a specific application (typically for admin)
    public function edit($id)
    {
        if (!Gate::allows('update', Application::class)) {
            return redirect()->route('login')->with('info', 'Please Login to edit an Application');
        }

        $application = Application::findOrFail($id);
        return view('applications.edit', ['application' => $application]);
    }

    // Update an application
    public function update(Request $request, $id)
    {
        Gate::authorize('update', Application::class);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'mobile_number' => ['required', 'string', 'min:10'],
            'supporting_statement' => ['nullable', 'string', 'max:1000'],
            'cv' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:2048'],
        ]);

        // Handle CV file upload if a new CV is uploaded
        if ($request->hasFile('cv')) {
            $cvFile = $request->file('cv');
            $cvPath = $cvFile->store('applications/cvs', 'public'); // Store the file in the public disk
            $data['cv_path'] = $cvPath; // Save the new file path
        }

        $application = Application::findOrFail($id);
        $application->update($data);

        return redirect()->route('applications.show', $id)->with('success', 'Application updated successfully!');
    }

    // Delete an application (admin)
    //TODO admin auth logic
    public function destroy($id)
    {
        Gate::authorize('delete', Application::class);

        $application = Application::findOrFail($id);
        $application->delete();

        return redirect()->route('applications.index')->with('success', 'Application deleted successfully!');
    }
}