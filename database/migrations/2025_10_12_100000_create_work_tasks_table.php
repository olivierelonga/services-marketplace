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
        Schema::create('work_tasks', function (Blueprint $table) {
            $table->id();

            // Basic Task Info
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status')->default('pending'); // pending, in_progress, completed
            $table->string('priority')->nullable(); // low, medium, high, urgent

            // Client & Location
            $table->string('client_name')->nullable();
            $table->string('client_contact')->nullable();
            $table->string('client_email')->nullable();
            $table->string('address')->nullable();
            $table->text('access_instructions')->nullable();

            // Task Details
            $table->text('materials_needed')->nullable();
            $table->text('tools_required')->nullable();
            $table->text('measurements')->nullable();
            $table->json('photos')->nullable(); // store file paths or URLs as JSON

            // Budget & Time
            $table->decimal('estimated_cost', 10, 2)->nullable();
            $table->decimal('actual_cost', 10, 2)->nullable();
            $table->decimal('estimated_hours', 8, 2)->nullable();
            $table->decimal('actual_hours', 8, 2)->nullable();

            // Outcome
            $table->text('work_completed')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('client_approved')->default(false);
            $table->date('date_completed')->nullable();

            // Management
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('follow_up_needed')->default(false);
            $table->text('safety_notes')->nullable();
            $table->text('warranty_notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_tasks');
    }
};