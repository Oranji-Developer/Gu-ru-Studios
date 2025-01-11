<?php

namespace App\Http\Requests\Admin\Course;

use App\Enum\Courses\AcademicClass;
use App\Enum\Courses\ArtsClass;
use App\Enum\Courses\CourseType;
use App\Enum\Courses\StatusEnum;
use App\Enum\Users\RoleEnum;
use App\Trait\FileHandleTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCourseRequest extends FormRequest
{
    use FileHandleTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->role === RoleEnum::ADMIN->value;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'mentor_id' => [
                'bail',
                'required',
                'exists:mentors,id'
            ],
            'title' => [
                'bail',
                'required',
                'string',
                'max:100'
            ],
            'desc' => [
                'bail',
                'required',
                'string',
            ],
            'capacity' => [
                'bail',
                'required',
                'integer',
                'min:1'
            ],
            'cost' => [
                'bail',
                'required',
            ],
            'disc' => [
                'bail',
                'required',
            ],
            'course_type' => [
                'bail',
                'required',
                Rule::in(CourseType::getValues())
            ],
            'class' => [
                'bail',
                'required',
                Rule::in(array_merge(AcademicClass::getValues(), ArtsClass::getValues()))
            ],
            'thumbnail' => [
                'bail',
                'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048'
            ],
            'status' => [
                'bail',
                'required',
                Rule::in(StatusEnum::getValues())
            ],
            'start_date' => [
                'bail',
                'required',
                'date'
            ],
            'end_date' => [
                'bail',
                'required',
                'date',
                'after:start_date'
            ],
            'day' => [
                'bail',
                'required',
                'string'
            ],
            'start_time' => [
                'bail',
                'required',
                'date_format:H:i'
            ],
            'end_time' => [
                'bail',
                'required',
                'date_format:H:i',
                'after:start_time'
            ],
            'total_meet' => [
                'bail',
                'required',
                'integer',
                'min:1'
            ]
        ];
    }

    protected function passedValidation(): void
    {
        $this->handle();
    }

    public function getCourse(): array
    {
        return [
            'mentor_id' => $this->input('mentor_id'),
            'title' => $this->input('title'),
            'desc' => $this->input('desc'),
            'capacity' => $this->input('capacity'),
            'cost' => $this->input('cost'),
            'disc' => $this->input('disc'),
            'course_type' => $this->input('course_type'),
            'class' => $this->input('class'),
            'thumbnail' => $this->input('thumbnail'),
            'status' => $this->input('status'),
        ];
    }

    public function getSchedule(): array
    {
        return [
            'start_date' => $this->input('start_date'),
            'end_date' => $this->input('end_date'),
            'day' => $this->input('day'),
            'start_time' => $this->input('start_time'),
            'end_time' => $this->input('end_time'),
            'total_meet' => $this->input('total_meet')
        ];
    }
}
