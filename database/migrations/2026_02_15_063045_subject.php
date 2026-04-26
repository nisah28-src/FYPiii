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
         Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('subject_name');
            $table->string('subject_code');
            $table->integer('credit_hours');
            $table->enum('category_type',['Core','MPU','Elective']);
            $table->unsignedBigInteger('pre_requisite_id')->nullable();
            $table->timestamps();

            $table->foreign('pre_requisite_id')
            ->references('id')
            ->on('subjects')
            ->onDelete('set null');
        });

        

        Schema::create('years', function (Blueprint $table) {
            $table->id();
            $table->integer('year_number');
            $table->timestamps();
        });

        Schema::create('semesters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('year_id')->constrained()->onDelete('cascade');
            $table->enum('semester_number',['1','2','3']);
            $table->timestamps();
        });

        Schema::create('program_structures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->integer('version')->default(1);
            $table->enum('status',['draft','pending','approved','rejected']);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('program_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_structure_id')->constrained()->onDelete('cascade');
            $table->foreignId('semester_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('years');
        Schema::dropIfExists('semesters');
        Schema::dropIfExists('program_subjects');
        Schema::dropIfExists('program_structures');
    }
};
