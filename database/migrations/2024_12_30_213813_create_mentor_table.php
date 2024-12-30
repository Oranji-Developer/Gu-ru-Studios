<?php

use App\Enum\Course\AcademicClass;
use App\Enum\Course\ArtsClass;
use App\Enum\Course\CourseType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mentor', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('desc');
            $table->string('profile_picture', 150)->nullable();
            $table->string('portfolio', 150)->nullable();
            $table->enum('course_type', CourseType::getValues());
            $table->enum('class', array_merge(AcademicClass::getValues(), ArtsClass::getValues()));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentor');
    }
};
