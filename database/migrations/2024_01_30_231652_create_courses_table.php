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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('details')->nullable();
            $table->text('duration')->nullable();
            $table->unsignedBigInteger('course_category_id');
            $table->foreign('course_category_id')->references('id')->on('course_categories')->onDelete('cascade');
            $table->text('image')->nullable();
            $table->decimal('regular_price', 10, 2)->nullable();
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->string('meet_link')->nullable();
            $table->string('whatsapp_group_link')->nullable();
            $table->string('facebook_group')->nullable();
            $table->string('zoom_link')->nullable();
            $table->string('youtube_playlist')->nullable();
            $table->integer('order')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('publish_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->dateTime('expired_date')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->boolean('lifetime_access')->default(false);
            $table->boolean('featured')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
