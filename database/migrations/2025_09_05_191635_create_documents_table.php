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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type'); // pdf, docx, pptx, jpg, png, mp4, etc.
            $table->string('mime_type');
            $table->bigInteger('file_size'); // in bytes
            $table->string('folder')->default('general'); // general, assignments, resources, etc.
            $table->text('description')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('is_shared')->default(false);
            $table->integer('download_count')->default(0);
            $table->timestamp('last_accessed_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'folder']);
            $table->index(['course_id', 'file_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
