<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Candidate extends Authenticatable
{
    use HasApiTokens;

    protected $guarded = [];

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }
}
