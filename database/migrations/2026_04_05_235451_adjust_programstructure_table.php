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
        Schema::create('program_structures', function (Blueprint $table) {
            $table->id();
            $table->string('program_structure_name')->default('test 1');
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->integer('version')->default(1);
            $table->enum('status',['draft','pending','approved','rejected']);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_structures');
    }
};
