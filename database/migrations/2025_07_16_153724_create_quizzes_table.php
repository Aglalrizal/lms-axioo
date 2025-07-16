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

        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_syllabus_id')->constrained();
            $table->string('title');
            $table->integer('number_of_questions');
            $table->integer('duration');
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
        Schema::dropIfExists('quizzes');
    }
};
