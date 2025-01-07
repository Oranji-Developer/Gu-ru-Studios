<?php

use App\Enum\Courses\AcademicClass;
use App\Enum\Courses\ArtsClass;
use App\Enum\Courses\CourseType;
use App\Enum\Users\GenderEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mentors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('address')->nullable();
            $table->enum('gender', GenderEnum::getValues());
            $table->text('desc');
            $table->string('profile_picture', 150)->nullable();
            $table->string('cv', 150)->nullable();
            $table->string('portfolio', 150)->nullable();
            $table->enum('field', CourseType::getValues());
            $table->timestamps();
            $table->softDeletes();
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
