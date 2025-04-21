<?php

namespace App\Jobs;

use App\Models\JobApplication;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessJobApplication implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected array $data) {}

    public function handle()
    {
        $resumePath = 'resumes/' . uniqid() . '_' . basename($this->data['resume_path']);
        Storage::move($this->data['resume_path'], $resumePath);

        $coverLetterPath = 'resumes/' . uniqid() . '_' . basename($this->data['resume_path']);
        Storage::move($this->data['resume_path'], $coverLetterPath);

        JobApplication::create([
            'candidate_id' => $this->data['candidate_id'],
            'job_post_id' => $this->data['job_post_id'],
            'cover_letter' => $coverLetterPath,
            'resume' => $resumePath,
        ]);
    }
}
