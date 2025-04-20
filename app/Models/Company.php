<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Company extends Model
{
    use HasApiTokens;

    protected $guarded = [];
}
