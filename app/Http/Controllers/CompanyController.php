<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|unique:companies,company_name|max:255',
            'email' => 'nullable|email|unique:companies,email',
            'phone_number' => 'nullable|string',
            'website' => 'nullable|url',
            'logo' => ['nullable', 'file', 'mimes:png,jpg', 'max:1024'], // File validation for the logo image
        ]);

           // TODO: take this out if on reflection its not needed
           //Handle the logo file if present
        //    if ($request->hasFile('logo')) {
        //     $file = $request->file('logo');
        //     $logoPath = $file->store('vacancies/logos', 'public'); // Store the file in the public disk
        //     $data['logo'] = $logoPath; // Save the file path
        // }

        $company = Company::create($validated);

        return response()->json([
            'message' => 'Company created successfully!',
            'company' => $company,
        ]);
    }
}