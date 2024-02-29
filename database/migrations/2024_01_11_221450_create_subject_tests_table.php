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
        Schema::create('subject_tests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('enrolled_code');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->uuid('subject_id');
            $table->uuid('created_by_id');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_tests');
    }
};
