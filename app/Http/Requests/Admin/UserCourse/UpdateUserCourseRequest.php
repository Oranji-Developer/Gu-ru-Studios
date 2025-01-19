<?php

namespace App\Http\Requests\Admin\UserCourse;

use App\Enum\Users\RoleEnum;
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
            'status' => [
                'required',
                'string',
                Rule::in(StatusEnum::getValues())
            ],
            'report' => [
                'string',
                'url'
            ],
        ];
    }

    public function getData(): array
    {
        return $this->only(['status']);
    }
}
