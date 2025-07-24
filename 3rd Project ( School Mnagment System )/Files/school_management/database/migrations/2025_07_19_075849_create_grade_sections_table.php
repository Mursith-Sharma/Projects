<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('grade_sections', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Grade 1 Section A"
            $table->foreignId('teacher_id')->nullable()->constrained('teachers');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('grade_sections');
    }
};