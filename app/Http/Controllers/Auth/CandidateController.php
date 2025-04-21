<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginCandidateRequest;
use App\Http\Requests\RegisterCandidateRequest;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CandidateController extends Controller
{
    public function register(RegisterCandidateRequest $request)
    {
        $candidateData = $request->validated();

        Candidate::create([
            'first_name' => $candidateData['first_name'],
            'last_name' => $candidateData['last_name'],
            'email' => $candidateData['email'],
            'password' => Hash::make($candidateData['password']),
        ]);

        return response()->json(['message' => 'Candidate registered successfully'], 201);
    }

    public function login(LoginCandidateRequest $request)
    {
        $request->validated();

        $candidate = Candidate::where('email', $request->email)->first();

        if (!$candidate || ! Hash::check($request->password, $candidate->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $candidate->createToken('CompanyToken')->accessToken;

        return response()->json([
            'candidate' => $candidate,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user('candidate')->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Logged out successfully']);
    }
}
