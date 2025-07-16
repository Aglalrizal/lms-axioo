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
        Schema::disableForeignKeyConstraints();

        Schema::create('course_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_syllabus_id')->constrained();
            $table->string('title');
            $table->longText('content');
            $table->string('video_url');
            $table->integer('order');
            $table->boolean('is_free_preview');
            $table->boolean('is_assessment');
            $table->boolean('is_completed');
            $table->string('created_by');
            $table->string('modified_by');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_contents');
    }
};
