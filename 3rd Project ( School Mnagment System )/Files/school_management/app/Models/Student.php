<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Student extends Authenticatable
{
    use Notifiable;

    protected $table = 'students';

protected $fillable = [
    'full_name', 'dob', 'gender', 'phone', 'email', 'password', 'role',
    'address', 'city', 'postal_code', 'grade', 'section',
    'admission_date', 'previous_school', 'guardian_name',
    'guardian_phone', 'relation',
];

    protected $hidden = [
        'password',
        'remember_token',
    ];

}
