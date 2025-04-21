<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateJobPostRequest;
use App\Http\Requests\UpdateJobPostRequest;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // used when for simplification but there is more elegant way to do this
        // to avoid using multiple where clauses
        // for example, you can use a spatial query builder 
        $jobPosts = JobPost::where('published_by', auth()->company()->id)
            ->when($request->input('search'), function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('description', 'like', '%' . $request->input('search') . '%');
            })
            ->when($request->input('location'), function ($query) use ($request) {
                $query->where('location', 'like', '%' . $request->input('location') . '%');
            })
            ->when($request->input('is_remote'), function ($query) use ($request) {
                $query->where('is_remote', $request->input('is_remote'));
            });

        if ($request->input('with_trashed')) {
            $jobPosts = $jobPosts->withTrashed();
        }

        return response()->json($jobPosts->paginated($request->input('per_page', 10)), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateJobPostRequest $request)
    {
        $validated = $request->validated();

        $jobPost = JobPost::create([...$validated, 'published_by' => auth()->company()->id]);

        return response()->json($jobPost, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(JobPost $job)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobPostRequest $request, JobPost $job)
    {
        $validated = $request->validated();

        $job->update($validated);

        return response()->json($job, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobPost $job)
    {
        $job->delete();

        return response()->json(['message' => 'Job post deleted successfully'], 200);
    }

    /**
     * Restore a soft-deleted job post.
     */
    public function restore($id)
    {
        $job = JobPost::onlyTrashed()->where('id', $id)->where('published_by', auth()->company()->id)->first();

        if (!$job) {
            return response()->json(['message' => 'Job post not found or unauthorized'], 404);
        }

        $job->restore();

        return response()->json(['message' => 'Job post restored successfully', 'job' => $job], 200);
    }
}
