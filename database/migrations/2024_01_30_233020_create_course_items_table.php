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
        Schema::create('course_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('course_module_id');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('course_module_id')->references('id')->on('course_modules')->onDelete('cascade');
            $table->string('title');
            $table->text('details')->nullable();
            $table->integer('order')->default(1);
            $table->string('video')->nullable();
            $table->string('image')->nullable();
            $table->string('file')->nullable();
            $table->unsignedBigInteger('exam_paper_id')->nullable();
            $table->string('youtube_video')->nullable();
            $table->string('url')->nullable();
            $table->string('youtube_playlist')->nullable();
            $table->string('pdf')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_items');
    }
};
