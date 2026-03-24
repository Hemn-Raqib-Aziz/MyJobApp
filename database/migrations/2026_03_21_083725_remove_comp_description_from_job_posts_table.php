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
    Schema::table('job_posts', function (Blueprint $table) {
        if (Schema::hasColumn('job_posts', 'comp_description')) {
            $table->dropColumn('comp_description');
        }
    });
}

public function down(): void
{
    Schema::table('job_posts', function (Blueprint $table) {
        $table->text('comp_description')->nullable();
    });
}
};
