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
         Schema::create('approval_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_structure_id')->constrained('program_structures')->onDelete('cascade');
            $table->enum('status',['pending','approved','returned'])->default('pending');
            $table->foreignId('requested_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');//add later
            $table->text('remarks')->nullable();//add later 
            $table->timestamps();
        });

         Schema::create('approval_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('approval_request_id')->constrained()->onDelete('cascade');
            $table->foreignId('action_by')->constrained('users')->onDelete('cascade');
            $table->string('action');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_requests');
        Schema::dropIfExists('approval_histories');
    }
};
