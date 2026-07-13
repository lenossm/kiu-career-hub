<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('vacancies', 'audience')) {
            Schema::table('vacancies', function (Blueprint $table) {
                $table->string('audience')->default('student')->after('type');
                $table->index('audience');
            });
        }

        if (! Schema::hasColumn('students', 'user_id')) {
            Schema::table('students', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
                $table->unique('user_id');
            });
        }

        Schema::create('professors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('full_name');
            $table->string('email');
            $table->string('department');
            $table->text('bio')->nullable();
            $table->string('photo_path')->nullable();
            $table->timestamps();
            $table->unique('user_id');
        });

        Schema::create('professor_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vacancy_id')->constrained()->cascadeOnDelete();
            $table->text('cover_letter');
            $table->string('resume_path')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
            $table->unique(['professor_id', 'vacancy_id']);
        });

        DB::table('users')->where('role', 'staff')->update(['role' => 'student']);
    }

    public function down(): void
    {
        Schema::dropIfExists('professor_applications');
        Schema::dropIfExists('professors');

        Schema::table('students', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });

        Schema::table('vacancies', function (Blueprint $table) {
            $table->dropIndex(['audience']);
            $table->dropColumn('audience');
        });
    }
};
