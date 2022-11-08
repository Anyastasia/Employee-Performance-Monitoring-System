<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Employee extends Authenticatable
{
    use HasFactory;

    protected $guard = 'employee';
    protected $fillable = ['first_name', 'last_name', 'email', 'division_id', 'position', 'avatar_path', 'password'];

}
