<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('exam_results', function (Blueprint $table) {
            // Kita tambahkan kolom-kolom baru ini
            $table->integer('written_score')->nullable()->after('interviewer_id');
            $table->integer('interview_score')->nullable()->after('written_score');
            $table->float('final_score')->nullable()->after('interview_score');
        });
    }

    public function down()
    {
        Schema::table('exam_results', function (Blueprint $table) {
            // Hapus kolom kalau migration di-rollback
            $table->dropColumn(['written_score', 'interview_score', 'final_score']);
        });
    }
};
