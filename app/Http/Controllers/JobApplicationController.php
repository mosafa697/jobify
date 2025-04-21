<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJobApplicationRequest;
use App\Jobs\ProcessJobApplication;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function apply(CreateJobApplicationRequest $request, $id)
    {
        $alreadyApplied = JobApplication::where('candidate_id', auth()->candidate()->id)
            ->where('job_id', $id)
            ->exists();

        if ($alreadyApplied) {
            return response()->json(['message' => 'You already applied for this job'], 409);
        }

        $resume = $request->file('resume')->store('temp-resumes');
        $cover_letter = $request->file('cover_letter')->store('temp-cover_letters');

        ProcessJobApplication::dispatch([
            'candidate_id' => auth()->candidate()->id,
            'job_post_id' => $id,
            'cover_letter' => $cover_letter,
            'resume_path' => $resume,
        ]);

        return response()->json(['message' => 'Application submitted and will be processed shortly.']);
    }
}
