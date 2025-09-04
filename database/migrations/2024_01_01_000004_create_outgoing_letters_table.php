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
        Schema::create('outgoing_letters', function (Blueprint $table) {
            $table->id();
            $table->string('letter_number')->unique()->comment('Nomor surat keluar');
            $table->string('recipient')->comment('Penerima surat');
            $table->string('subject')->comment('Perihal/subjek surat');
            $table->date('letter_date')->comment('Tanggal surat');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium')->comment('Tingkat prioritas');
            $table->enum('status', ['draft', 'sent', 'archived'])->default('draft')->comment('Status surat');
            $table->text('content')->comment('Isi surat');
            $table->string('file_path')->nullable()->comment('Path file surat');
            $table->text('notes')->nullable()->comment('Catatan tambahan');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('letter_number');
            $table->index('recipient');
            $table->index('letter_date');
            $table->index('status');
            $table->index(['status', 'priority']);
            $table->index(['letter_date', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outgoing_letters');
    }
};