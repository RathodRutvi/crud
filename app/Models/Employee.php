<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    public $table ="employees";
    protected  $fillable = ['id','profile_image','first_name','last_name','email','user_name','birth_date','gender','password','confirm_password'];
}
