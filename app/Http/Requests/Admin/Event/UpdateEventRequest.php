<?php

namespace App\Http\Requests\Admin\Event;

use App\Enum\Courses\StatusEnum;
use App\Enum\Users\RoleEnum;
use App\Trait\FileHandleTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEventRequest extends FormRequest
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
            'status' => [
                'required',
                Rule::in(StatusEnum::getValues())
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Status harus diisi',
            'status.in' => 'Status tidak valid',
        ];
    }

    protected function passedValidation(): void
    {
        $this->handle();
    }

    public function getData(): array
    {
        return [
            'status' => $this->status,
        ];
    }
}
