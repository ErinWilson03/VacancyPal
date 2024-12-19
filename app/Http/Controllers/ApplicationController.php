<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Vacancy;
use App\Services\ApplicationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ApplicationController extends Controller
{
    protected $applicationService;

    public function __construct(ApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    // Display all applications (admin or HR view)
    public function index(Request $request)
    {
        if (!Gate::allows('viewAny', Application::class)) {
            return redirect()->route('login')->with('info', 'Please Login to view Applications');
        }

        $applications = $this->applicationService->getAllApplications($request);

        return view('applications.index', [
            'applications' => $applications,
            'search' => $request->input('search', null)
        ]);
    }

    // Show the form to create a new application for a specific vacancy
    public function create($vacancyId)
    {
        $vacancy = Vacancy::findOrFail($vacancyId);

        if (!Gate::allows('create', $vacancy)) {
            return redirect()->route('vacancies.index')->with('warning', 'Only registered account holders can apply for vacancies');
        }

        return view('applications.create', ['vacancy' => $vacancy]);
    }

    // Store a newly created application
    public function store(Request $request)
    {
        Gate::authorize('apply', Application::class);

        $this->applicationService->storeApplication($request);

        return redirect()->route('vacancies.index')->with('success', 'Your application has been submitted successfully!');
    }

    // Show a specific application details
    public function show($id)
    {
        if (!Gate::allows('view', Application::class)) {
            return redirect()->route('login')->with('info', 'Please Login to view an Application');
        }

        $application = $this->applicationService->getApplicationDetails($id);

        return view('applications.show', ['application' => $application]);
    }

    // Show form for editing a specific application (typically for admin)
    public function edit($id)
    {
        if (!Gate::allows('update', Application::class)) {
            return redirect()->route('login')->with('info', 'Please Login to edit an Application');
        }

        $application = $this->applicationService->getApplicationForEdit($id);

        return view('applications.edit', ['application' => $application]);
    }

    // Update an application
    public function update(Request $request, $id)
    {
        Gate::authorize('update', Application::class);

        $this->applicationService->updateApplication($request, $id);

        return redirect()->route('applications.show', $id)->with('success', 'Application updated successfully!');
    }

    // Delete an application (admin)
    public function destroy($id)
    {
        Gate::authorize('delete', Application::class);

        $this->applicationService->deleteApplication($id);

        return redirect()->route('applications.index')->with('success', 'Application deleted successfully!');
    }
}
