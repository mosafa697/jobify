<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginCompanyRequest;
use App\Http\Requests\RegisterCompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    public function register(RegisterCompanyRequest $request)
    {
        $companyData = $request->validated();

        Company::create([
            'name' => $companyData['name'],
            'email' => $companyData['email'],
            'password' => Hash::make($companyData['password']),
        ]);

        return response()->json(['message' => 'Company registered successfully'], 201);
    }

    public function login(LoginCompanyRequest $request)
    {
        $request->validated();

        $company = Company::where('email', $request->email)->first();

        if (!$company || ! Hash::check($request->password, $company->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $company->createToken('CompanyToken')->accessToken;

        return response()->json([
            'company' => $company,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user('company')->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Logged out successfully']);
    }
}
