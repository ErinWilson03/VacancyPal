<?php

namespace App\Services;

use App\Models\Application;
use App\Models\Vacancy;
use Illuminate\Http\Request;

class ApplicationService
{
    // Fetch all applications based on the search and sorting
    public function getAllApplications(Request $request)
    {
        $size = $request->input('size', 10);
        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'asc');
        $search = $request->input('search', null);

        return Application::with('vacancy') // Include vacancy details in the query
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->sortable($sort, $direction)
            ->paginate($size)
            ->withQueryString();
    }

    // Handle the storing of a new application
    public function storeApplication(Request $request)
    {
        // Validate the incoming request
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:applications,email'],
            'mobile_number' => ['required', 'string', 'min:10'],
            'supporting_statement' => ['nullable', 'string', 'max:1000'],
            'cv' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:2048'],
            'vacancy_id' => ['required', 'exists:vacancies,id'],
        ]);

        // Handle CV file upload
        if ($request->hasFile('cv')) {
            $cvFile = $request->file('cv');
            $cvPath = $cvFile->store('applications/cvs', 'public'); // Store the file in the public disk
            $data['cv_path'] = $cvPath; // Save the file path in the database
        }

        // Create the application record in the database
        Application::create($data);
    }

    // Fetch a specific application details
    public function getApplicationDetails($id)
    {
        return Application::with('vacancy')->findOrFail($id);
    }

    // Get the application for editing
    public function getApplicationForEdit($id)
    {
        return Application::findOrFail($id);
    }

    // Handle the update of an application
    public function updateApplication(Request $request, $id)
    {
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
            $cvPath = $cvFile->store('applications/cvs', 'public'); // Store the file
            $data['cv_path'] = $cvPath; // Save the new file path
        }

        $application = Application::findOrFail($id);
        $application->update($data);
    }

    // Handle the deletion of an application
    public function deleteApplication($id)
    {
        $application = Application::findOrFail($id);
        $application->delete();
    }
}
