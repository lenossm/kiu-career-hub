<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('staff')->after('password');
            });
        }

        if (! Schema::hasColumn('students', 'photo_path')) {
            Schema::table('students', function (Blueprint $table) {
                $table->string('photo_path')->nullable()->after('linkedin_link');
            });
        }

        if (! Schema::hasColumn('applications', 'resume_path')) {
            Schema::table('applications', function (Blueprint $table) {
                $table->string('resume_path')->nullable()->after('cover_letter');
            });
        }

        $duplicateGroups = DB::table('applications')
            ->select('student_id', 'vacancy_id', DB::raw('MIN(id) as keep_id'))
            ->groupBy('student_id', 'vacancy_id')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicateGroups as $group) {
            DB::table('applications')
                ->where('student_id', $group->student_id)
                ->where('vacancy_id', $group->vacancy_id)
                ->where('id', '!=', $group->keep_id)
                ->delete();
        }

        Schema::table('applications', function (Blueprint $table) {
            $table->unique(['student_id', 'vacancy_id']);
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropUnique(['student_id', 'vacancy_id']);
            $table->dropColumn('resume_path');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('photo_path');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
