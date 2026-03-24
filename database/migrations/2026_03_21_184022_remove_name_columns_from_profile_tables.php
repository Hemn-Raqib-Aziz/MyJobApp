<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('job_seekers', function (Blueprint $table) {
        $table->dropColumn('full_name');
    });

    Schema::table('job_posters', function (Blueprint $table) {
        $table->dropColumn('job_poster_name');
    });
}

public function down(): void
{
    Schema::table('job_seekers', function (Blueprint $table) {
        $table->string('full_name');
    });

    Schema::table('job_posters', function (Blueprint $table) {
        $table->string('job_poster_name');
    });
}
};
