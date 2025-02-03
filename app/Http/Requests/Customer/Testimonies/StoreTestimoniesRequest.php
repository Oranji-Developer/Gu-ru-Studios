<?php

namespace App\Http\Requests\Customer\Testimonies;

use App\Enum\Users\RatingEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTestimoniesRequest extends FormRequest
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
            'userCourse_id' => [
                'required',
                'exists:user_courses,id'
            ],
            'desc' => [
                'required',
                'string',
                'max:500'
            ],
            'rating' => [
                'required',
                Rule::in(RatingEnum::getValues())
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'desc.required' => 'Deskripsi harus diisi',
            'desc.string' => 'Deskripsi harus berupa karakter',
            'desc.max' => 'Deskripsi maksimal 500 karakter',
            'rating.required' => 'Rating harus diisi',
            'rating.in' => 'Rating tidak valid',
        ];
    }

    public function getData():array
    {
        return $this->validated();
    }
}
