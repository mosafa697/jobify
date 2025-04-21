<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJobApplicationRequest;
use App\Jobs\ProcessJobApplication;
use App\Models\JobApplication;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function apply(CreateJobApplicationRequest $request, int $id)
    {
        $jobExists = JobPost::where('id', $id)->exists();

        if (!$jobExists) {
            return response()->json(['message' => 'The specified job does not exist'], 404);
        }

        $alreadyApplied = JobApplication::where('candidate_id', 1) //$request->user('candidate')->id
            ->where('job_post_id', $id)
            ->exists();

        if ($alreadyApplied) {
            return response()->json(['message' => 'You already applied for this job'], 409);
        }

        $cover_letter = $request->file('cover_letter')?->store('temp-cover_letters');
        $resume = $request->file('resume')->store('temp-resumes');

        ProcessJobApplication::dispatch([
            'candidate_id' => 1, // $request->user('candidate')->id
            'job_post_id' => $id,
            'cover_letter' => $cover_letter,
            'resume_path' => $resume,
        ]);

        return response()->json(['message' => 'Application submitted and will be processed shortly.']);
    }
}
