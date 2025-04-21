<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Company extends Authenticatable
{
    use HasApiTokens;

    protected $guarded = [];

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class);
    }
}
