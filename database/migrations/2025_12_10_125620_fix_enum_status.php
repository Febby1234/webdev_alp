<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ubah enum status di tabel registrations untuk menambahkan 'accepted' dan 'rejected'
        DB::statement("ALTER TABLE registrations MODIFY COLUMN status ENUM(
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
        ) DEFAULT 'pending'");

        // Ubah enum status di tabel payments untuk konsistensi
        DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM(
            'pending',
            'verified',
            'rejected'
        ) DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke enum semula
        DB::statement("ALTER TABLE registrations MODIFY COLUMN status ENUM(
            'pending',
            'documents_pending',
            'documents_verified',
            'payment_pending',
            'paid',
            'exam_scheduled',
            'interview_scheduled',
            'finished'
        ) DEFAULT 'pending'");

        DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM(
            'pending',
            'approved',
            'rejected'
        ) DEFAULT 'pending'");
    }
};
