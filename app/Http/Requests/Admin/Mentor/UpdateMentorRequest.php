<?php

namespace App\Http\Requests\Admin\Mentor;

use App\Enum\Courses\CourseType;
use App\Enum\Users\GenderEnum;
use App\Enum\Users\RoleEnum;
use App\Trait\FileHandleTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMentorRequest extends FormRequest
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
            'name' => [
                'bail',
                'nullable',
                'string',
                'max:100'
            ],
            'address' => [
                'bail',
                'nullable',
                'string',
                'max:255'
            ],
            'gender' => [
                'bail',
                'nullable',
                Rule::in(GenderEnum::getValues())
            ],
            'desc' => [
                'bail',
                'nullable',
                'string',
            ],
            'profile_picture' => [
                'bail',
                'nullable',
                Rule::when(
                    is_file($this->profile_picture),
                    ['image', 'mimes:jpg,jpeg,png', 'max:2048'],
                    ['string']
                )
            ],
            'cv' => [
                'bail',
                'nullable',
                Rule::when(
                    is_file($this->cv),
                    ['mimes:jpg,jpeg,png,pdf', 'max:2048'],
                    ['string']
                )
            ],
            'portfolio' => [
                'bail',
                'nullable',
                Rule::when(
                    is_file($this->portfolio),
                    ['mimes:jpg,jpeg,png,pdf', 'max:2048'],
                    ['string']
                )
            ],
            'field' => [
                'bail',
                'nullable',
                Rule::in(CourseType::getValues())
            ],
            'phone' => [
                'bail',
                'nullable',
                'string',
                'max:20'
            ]
        ];
    }

    protected function passedValidation(): void
    {
        $this->handle();
    }

    public function getData(): array
    {
        return [
            'name' => $this->input('name'),
            'address' => $this->input('address'),
            'gender' => $this->input('gender'),
            'desc' => $this->input('desc'),
            'profile_picture' => $this->input('profile_picture'),
            'cv' => $this->input('cv'),
            'portfolio' => $this->input('portfolio'),
            'field' => $this->input('field'),
            'phone' => $this->input('phone')
        ];
    }
}
