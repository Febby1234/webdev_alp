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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('major_id')->constrained('majors');
            $table->foreignId('batch_id')->constrained('batches');
            $table->enum('status', [
                'pending',
                'documents_pending',
                'documents_verified',
                'payment_pending',
                'paid',
                'exam_scheduled',
                'interview_scheduled',
                'finished'
            ])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
