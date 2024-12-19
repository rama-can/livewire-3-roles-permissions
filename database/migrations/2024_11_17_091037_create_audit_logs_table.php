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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('description');          // Action description (created, updated, deleted)
            $table->string('subject_id')->nullable(); // ID of the affected model
            $table->string('subject_type');         // Type of the model
            $table->foreignUuid('user_id')->nullable()->constrained()->cascadeOnDelete(); // ID of the user who made the change
            $table->json('properties')->nullable(); // Old and new values in JSON format
            $table->string('host')->nullable();     // IP address
            $table->text('user_agent')->nullable(); // User agent
            $table->timestamps();                  // Created at, Updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
