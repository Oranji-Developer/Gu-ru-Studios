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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->text('desc');
            $table->string('thumbnail', 150)->nullable();
            $table->decimal('disc', 5, 2)->default(0);
            $table->enum('course_type', CourseType::getValues());
            $table->enum('class', array_merge(AcademicClass::getValues(), ArtsClass::getValues()))->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', StatusEnum::getValues());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
