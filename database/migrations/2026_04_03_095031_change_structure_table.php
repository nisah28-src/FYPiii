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
         Schema::create('program_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_structure_id')->constrained()->onDelete('cascade');
            $table->integer('semester_number');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->boolean('is_compulsory')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
                Schema::dropIfExists('program_subjects');
    }
};
