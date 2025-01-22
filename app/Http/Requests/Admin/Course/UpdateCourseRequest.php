<?php

namespace App\Http\Requests\Admin\Course;

use App\Enum\Courses\AcademicClass;
use App\Enum\Courses\ArtsClass;
use App\Enum\Courses\CourseType;
use App\Enum\Courses\StatusEnum;
use App\Enum\Users\RoleEnum;
use App\Trait\FileHandleTrait;
use Carbon\Carbon;
use Illuminate\Validation\Validator;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCourseRequest extends FormRequest
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
                'exists:mentors,id'
            ],
            'title' => [
                'bail',
                'string',
                'max:100'
            ],
            'desc' => [
                'bail',
                'string',
            ],
            'capacity' => [
                'bail',
                'integer',
                'min:1'
            ],
            'cost' => [
                'bail',
            ],
            'disc' => [
                'bail',
            ],
            'course_type' => [
                'bail',
                Rule::in(CourseType::getValues())
            ],
            'class' => [
                'bail',
                Rule::in(array_merge(AcademicClass::getValues(), ArtsClass::getValues()))
            ],
            'thumbnail' => [
                'bail',
                'nullable',
                Rule::when(
                    is_file($this->thumbnail),
                    ['image', 'mimes:jpg,jpeg,png', 'max:2048'],
                    ['string']
                )
            ],
            'status' => [
                'bail',
                Rule::in(StatusEnum::getValues())
            ],
            'start_date' => [
                'bail',
                'date'
            ],
            'end_date' => [
                'bail',
                'date',
                'after:start_date'
            ],
            'day' => [
                'bail',
                'array',
                Rule::in(['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'])
            ],
            'start_time' => [
                'bail',
                'date_format:H:i'
            ],
            'end_time' => [
                'bail',
                'date_format:H:i',
                'after:start_time'
            ],
            'total_meet' => [
                'bail',
                'integer',
                'min:1'
            ]
        ];
    }

    protected function passedValidation(): void
    {
        $this->handle();
    }

    protected function after(): array
    {
        return [

            function (Validator $validator) {
                if ($this->input('course_type') !== CourseType::ABK->value) {
                    if ($this->input('class') === null) {
                        $validator->errors()->add('class', 'The class field is required for course type');
                    } else {
                        if ($this->input('course_type') === CourseType::ACADEMIC->value) {
                            if (!in_array($this->input('class'), AcademicClass::getValues())) {
                                $validator->errors()->add('class', 'The class field is invalid for AcademicClass');
                            } else {
                                $this->merge(['class' => AcademicClass::from($this->input('class'))->value]);
                            }
                        } else {
                            if (!in_array($this->input('class'), ArtsClass::getValues())) {
                                $validator->errors()->add('class', 'The class field is invalid for ArtsClass');
                            } else {
                                $this->merge(['class' => ArtsClass::from($this->input('class'))->value]);
                            }
                        }
                    }
                }
            }
        ];
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
            'start_date' => Carbon::parse($this->input('start_date'))->format('Y-m-d'),
            'end_date' => Carbon::parse($this->input('end_date'))->format('Y-m-d'),
            'day' => implode(',', $this->input('day')),
            'start_time' => $this->input('start_time'),
            'end_time' => $this->input('end_time'),
            'total_meet' => $this->input('total_meet')
        ];
    }
}
