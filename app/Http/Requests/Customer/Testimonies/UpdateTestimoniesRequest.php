<?php

namespace App\Http\Requests\Customer\Testimonies;

use App\Enum\Users\RatingEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTestimoniesRequest extends FormRequest
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
            'desc' => [
                'string',
                'max:500'
            ],
            'rating' => [
                Rule::in(RatingEnum::getValues())
            ],
        ];
    }

    public function messages()
    {
        return [
            'desc.string' => 'Deskripsi harus berupa karakter',
            'desc.max' => 'Deskripsi maksimal 500 karakter',
            'rating.in' => 'Rating tidak valid',
        ];
    }

    public function getData(): array
    {
        return $this->validated();
    }
}
