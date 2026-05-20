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
            $table->string('subject_name_snapshot')->nullable();
            $table->integer('credit_hours_snapshot')->nullable();
            $table->boolean('is_compulsory')->default(true);
            $table->timestamps();
        });

        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('subject_name');
            $table->string('subject_code');
            $table->integer('credit_hours');
            $table->enum('category_type',['Core','MPU','Elective']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_subjects');
        Schema::dropIfExists('subjects');
    }
};
