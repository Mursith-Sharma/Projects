<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('teachers', function (Blueprint $table) {
            // Add grade_sections column if not exists
            if (!Schema::hasColumn('teachers', 'grade_sections')) {
                $table->json('grade_sections')->nullable()->after('previous_institution');
            }
            
            // Add designations column if not exists
            if (!Schema::hasColumn('teachers', 'designations')) {
                $table->json('designations')->nullable()->after('grade_sections');
            }
        });
    }

    public function down()
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn(['grade_sections', 'designations']);
        });
    }
};