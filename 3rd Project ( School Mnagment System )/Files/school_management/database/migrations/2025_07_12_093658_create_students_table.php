<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->date('dob');
            $table->string('gender');
            $table->string('phone');
            $table->string('email')->nullable()->unique();
            $table->string('password')->nullable();
            $table->string('role');
            $table->text('address');
            $table->string('city');
            $table->string('postal_code')->nullable();
            $table->string('grade');
            $table->string('section');
            $table->date('admission_date');
            $table->string('previous_school')->nullable();
            $table->string('guardian_name');
            $table->string('guardian_phone');
            $table->string('relation');
            $table->rememberToken(); // 👈 Added for Remember Me functionality
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
        $table->string('email')->nullable(false)->change();
        $table->string('password')->nullable(false)->change();
    });
    }
};
