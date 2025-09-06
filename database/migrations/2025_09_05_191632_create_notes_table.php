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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('content'); // Rich text content
            $table->string('note_type')->default('lecture'); // lecture, study_guide, practice, etc.
            $table->integer('week_number')->nullable();
            $table->date('lecture_date')->nullable();
            $table->json('tags')->nullable(); // Array of tags
            $table->json('media_files')->nullable(); // Images, videos, audio files
            $table->json('drawings')->nullable(); // Drawing data
            $table->boolean('is_important')->default(false);
            $table->boolean('is_shared')->default(false);
            $table->integer('view_count')->default(0);
            $table->timestamp('last_viewed_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'course_id']);
            $table->index(['course_id', 'week_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
