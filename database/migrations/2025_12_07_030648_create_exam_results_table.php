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
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained('registrations')->onDelete('cascade');
            $table->foreignId('schedule_id')->nullable()->constrained('schedules')->onDelete('set null');
            $table->foreignId('interviewer_id')->constrained('users')->onDelete('cascade');
            $table->integer('score');
            $table->enum('status', ['pending', 'pass', 'fail'])->default('pending'); // ✅ Using 'status' not 'result'
            $table->text('notes')->nullable();
            $table->timestamps();

            // Index untuk performance
            $table->index('status');
            $table->index('interviewer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_results');
    }
};
