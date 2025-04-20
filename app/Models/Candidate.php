<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Candidate extends Model
{
    use HasApiTokens;

    protected $guarded = [];
}
