<?php

use App\Enum\Courses\AcademicClass;
use App\Enum\Courses\ArtsClass;
use App\Enum\Courses\CourseType;
use App\Enum\Courses\StatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentor_id')->constrained('mentors')->cascadeOnDelete();
            $table->string('title', 100);
            $table->text('desc');
            $table->integer('capacity');
            $table->integer('enrolled')->default(0);
            $table->decimal('cost', 10, 2);
            $table->decimal('disc', 5, 2)->default(0);
            $table->enum('course_type', CourseType::getValues());
            $table->enum('class', array_merge(AcademicClass::getValues(), ArtsClass::getValues()))->nullable();
            $table->string('thumbnail', 150)->nullable();
            $table->enum('status', StatusEnum::getValues());
            $table->timestamps();
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
