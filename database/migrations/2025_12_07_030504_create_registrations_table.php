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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('major_id')->constrained('majors')->onDelete('cascade');
            $table->foreignId('batch_id')->constrained('batches')->onDelete('cascade');
            $table->string('registration_code')->unique(); // ✅ FIXED: Added this field!
            $table->enum('status', [
                'pending',
                'documents_pending',
                'documents_verified',
                'payment_pending',
                'paid',
                'exam_scheduled',
                'interview_scheduled',
                'finished',
                'accepted',
                'rejected'
            ])->default('pending');
            $table->timestamps();

            // Indexes untuk performance
            $table->index('registration_code');
            $table->index('status');
            $table->index(['major_id', 'batch_id']);
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
