<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        Student::create([
            'full_name'       => 'Test Student',
            'email'           => 'student@example.com',
            'password'        =>  Hash::make('12345678'),
            'role'            => 'student',
            'dob'             => '2005-01-01',
            'gender'          => 'Male',
            'phone'           => '0712345678',
            'address'         => 'Sample Address',
            'city'            => 'Colombo',
            'postal_code'     => '10000',
            'grade'           => '10',
            'section'         => 'A',
            'admission_date'  => now(),
            'previous_school' => 'ABC School',
            'guardian_name'   => 'John Doe',
            'guardian_phone'  => '0777777777',
            'relation'        => 'Father',
        ]);
        
    }
}
?>