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
        Schema::create('letter_archives', function (Blueprint $table) {
            $table->id();
            $table->enum('letter_type', ['incoming', 'outgoing'])->comment('Jenis surat');
            $table->unsignedBigInteger('letter_id')->comment('ID surat (incoming atau outgoing)');
            $table->string('archive_number')->unique()->comment('Nomor arsip');
            $table->string('category')->comment('Kategori arsip');
            $table->text('archive_notes')->nullable()->comment('Catatan arsip');
            $table->foreignId('archived_by')->constrained('users');
            $table->timestamp('archived_at')->comment('Waktu pengarsipan');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('letter_type');
            $table->index('letter_id');
            $table->index(['letter_type', 'letter_id']);
            $table->index('archive_number');
            $table->index('category');
            $table->index('archived_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letter_archives');
    }
};