<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exports', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('file_path');
            $table->enum('status', ['pending', 'completed', 'failed', 'started'])->default('pending');
            $table->integer('query_count')->default(0);
            $table->integer('total_rows')->default(0);
            $table->integer('processed_rows')->default(0);
            $table->longText('content')->nullable();
            $table->longText('stack_trace')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exports');
    }
};
