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
        ]);

        $company = Company::create($validated);

        return response()->json([
            'message' => 'Company created successfully!',
            'company' => $company,
        ]);
    }
}