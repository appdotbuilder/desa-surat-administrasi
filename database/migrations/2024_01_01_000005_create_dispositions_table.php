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
        Schema::create('dispositions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incoming_letter_id')->constrained('incoming_letters')->onDelete('cascade');
            $table->foreignId('assigned_to')->constrained('users');
            $table->foreignId('assigned_by')->constrained('users');
            $table->text('instructions')->comment('Instruksi disposisi');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium')->comment('Tingkat prioritas');
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending')->comment('Status disposisi');
            $table->date('due_date')->nullable()->comment('Batas waktu penyelesaian');
            $table->text('notes')->nullable()->comment('Catatan tambahan');
            $table->text('completion_notes')->nullable()->comment('Catatan penyelesaian');
            $table->timestamp('completed_at')->nullable()->comment('Waktu penyelesaian');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('incoming_letter_id');
            $table->index('assigned_to');
            $table->index('assigned_by');
            $table->index('status');
            $table->index('due_date');
            $table->index(['assigned_to', 'status']);
            $table->index(['status', 'due_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispositions');
    }
};