<?php

use App\Enums\AccessType;
use App\Enums\CourseLevel;
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

        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->foreignId('teacher_id')->constrained('users');
            $table->foreignId('course_category_id')->constrained()->cascadeOnDelete();
            $table->longText('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->enum('access_type', AccessType::values());
            $table->decimal('price', 10, 2)->default(0);
            $table->enum('level', CourseLevel::values());
            $table->integer('duration')->nullable();
            $table->longText('extra_description')->nullable();
            $table->boolean('is_published')->default(false);
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
