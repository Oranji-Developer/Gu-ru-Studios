<?php

namespace App\Http\Requests\Customer\UserCourse;

use App\Enum\Users\StatusEnum;
use App\Models\Course;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $course = Course::findOrFail($this->course_id);
        if ($course->capacity == $course->enrolled) {
            $this->validator->errors()->add('course_id', 'Kuota penuh');
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'course_id' => [
                'required',
                'integer',
                'exists:courses,id'
            ],
            'children_id' => [
                'required',
                'integer',
                'exists:children,id'
            ],
        ];
    }

    protected function passedValidation(): void
    {
        $this->merge([
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'status' => StatusEnum::UNPAID->value
        ]);
    }

    public function getData(): array
    {
        return $this->only(['course_id', 'children_id', 'start_date', 'end_date', 'status']);
    }
}
