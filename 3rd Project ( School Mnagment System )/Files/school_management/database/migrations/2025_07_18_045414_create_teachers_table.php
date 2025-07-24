<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('teachers', function (Blueprint $table) {
        $table->id();
        $table->string('full_name');
        $table->date('dob');
        $table->enum('gender', ['male', 'female', 'other']);
        $table->string('phone');
        $table->string('email')->unique()->nullable();
        $table->string('password')->nullable();
        $table->string('role')->default('teacher');
        $table->text('address');
        $table->string('city');
        $table->string('postal_code', 20)->nullable();
        $table->string('qualification');
        $table->string('specialization');
        $table->unsignedInteger('experience');
        $table->date('joining_date');
        $table->string('previous_institution')->nullable();
        $table->json('grade_sections'); // No default here
        $table->json('designations')->nullable();
        $table->string('resume_path')->nullable();
        $table->string('emergency_name');
        $table->string('emergency_phone');
        $table->string('relation');
        $table->rememberToken();
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('teachers');
    }
};
?>