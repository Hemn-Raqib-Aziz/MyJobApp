<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('job_posts', function (Blueprint $table) {
        $table->dropForeign(['job_poster_id']);
        
        $table->foreign('job_poster_id')
              ->references('id')
              ->on('job_posters')
              ->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('job_posts', function (Blueprint $table) {
        $table->dropForeign(['job_poster_id']);
        $table->foreign('job_poster_id')
              ->references('id')
              ->on('users')
              ->onDelete('cascade');
    });
}
};
