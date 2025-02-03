<?php

namespace App\Http\Requests\Customer\UserCourse;

use App\Enum\Users\StatusEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserCourseRequest extends FormRequest
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
            'status' => [
                'bail',
                'string',
                Rule::in(StatusEnum::getValues())
            ]
        ];
    }

    public function getData(): array
    {
        return $this->only(['status']);
    }
}
