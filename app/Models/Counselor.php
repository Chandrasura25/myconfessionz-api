<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Counselor extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = 'counselors';
    protected $fillable = [
        "username",
        "first_name",
        "last_name",
        "image",
        "counseled_clients",
        "counseling_field",
        "earnings",
        "satisfied_clients",
        'dob',
        'gender',
        'password',
        'country',
        'state',
        'recovery_question1',
        'answer1',
        'recovery_question2',
        'answer2',
        'recovery_question3',
        'answer3'
    ];
}
