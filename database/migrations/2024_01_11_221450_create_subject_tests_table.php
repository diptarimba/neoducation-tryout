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
            $table->id();
            $table->string('name');
            $table->string('enrolled_code');
            $table->timestamp('start_at');
            $table->timestamp('end_at');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('created_by_id');
            $table->timestamps();
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
