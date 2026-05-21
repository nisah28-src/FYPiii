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
        Schema::table('program_subjects', function (Blueprint $table) {
            $table->string('subject_code_snapshot')->nullable()->after('subject_name_snapshot');
            $table->text('prerequisites')->nullable()->after('credit_hours_snapshot');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('program_subjects', function (Blueprint $table) {
            $table->dropColumn('subject_code_snapshot');
            $table->dropColumn('prerequisites');
         });
    }
};
