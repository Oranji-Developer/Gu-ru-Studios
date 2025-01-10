<?php

namespace App\Http\Requests\Customer\Children;

use App\Enum\Courses\AcademicClass;
use App\Enum\Users\GenderEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateChildrenRequest extends FormRequest
{
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'bail',
                'string',
                'max:100'
            ],
            'class' => [
                'bail',
                Rule::in(AcademicClass::getValues())
            ],
            'gender' => [
                'bail',
                Rule::in(GenderEnum::getValues())
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Nama harus berupa karakter',
            'name.max' => 'Nama maksimal 100 karakter',
            'class.in' => 'Kelas tidak valid',
            'gender.in' => 'Jenis kelamin tidak valid',
        ];
    }

    public function getData(): array
    {
        return [
            'user_id' => auth()->id(),
            'name' => $this->name,
            'class' => $this->class,
            'gender' => $this->gender,
        ];
    }
}