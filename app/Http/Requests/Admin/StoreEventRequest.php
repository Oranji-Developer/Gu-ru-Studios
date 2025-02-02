<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enum\Courses\CourseType;
use App\Enum\Courses\AcademicClass;
use App\Enum\Courses\ArtsClass;
use App\Trait\FileHandleTrait;


class StoreEventRequest extends FormRequest
{
    use FileHandleTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'bail',
                'required',
                'string',
                'max:100',
            ],
            'thumbnail' => [
                'bail',
                'required',
                'image',
                'mimes:jpeg,png,jpg',
                'max:2048',
            ],
            'desc' => [
                'bail',
                'required',
                'string',
                'max:255',
            ],
            'disc' => [
                'bail',
                'required',
                'numeric',
                'between:0,9999.99',
            ],
            'course_type' => [
                'bail',
                'required',
                Rule::in(CourseType::getValues()),
            ],
            'class' => [
                'bail',
                'required',
                Rule::in(array_merge(AcademicClass::getValues(), ArtsClass::getValues())),
            ],
            'start_date' => [
                'bail',
                'required',
                'date',
            ],
            'end_date' => [
                'bail',
                'required',
                'date',
            ],

        ];
    }

    protected function passedValidation()
    {
        $this->handle();
    }

    public function getData():array
    {
        return [
            'title' => $this->title->input('title'),
            'thumbnail' => $this->thumbnail->input('thumbnail'),
            'desc' => $this->desc->input('desc'),
            'disc' => $this->disc->input('disc'),
            'course_type' => $this->course_type->input('course_type'),
            'class' => $this->class->input('class'),
            'start_date' => $this->start_date->input('start_date'),
            'end_date' => $this->end_date->input('end_date'),
        ];
    }
}
