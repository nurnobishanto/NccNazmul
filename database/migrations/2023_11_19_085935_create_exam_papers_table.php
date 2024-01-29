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
        Schema::create('exam_papers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('subject_id');
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->unsignedBigInteger('exam_category_id');
            $table->foreign('exam_category_id')->references('id')->on('exam_categories');
            $table->unsignedBigInteger('batch_id');
            $table->foreign('batch_id')->references('id')->on('batches');
            $table->double('duration')->default(5);
            $table->double('pmark')->nullable();
            $table->double('nmark')->nullable();
            $table->date('startdate')->nullable();
            $table->date('enddate')->nullable()->default('3000-12-31');
            $table->time('starttime')->nullable();
            $table->time('endtime')->nullable()->default('23:59:59');
            $table->string('password')->nullable();
            $table->integer('limit')->default(5);
            $table->integer('max_limit')->default(50);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_papers');
    }
};
