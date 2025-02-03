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
                'string'
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

    public function messages(): array
    {
        return [
            'name.string' => 'Nama harus berupa huruf',
            'name.max' => 'Nama maksimal berukuran 100 karakter',
            'address.string' => 'Alamat harus berupa huruf',
            'address.max' => 'Alamat maksimal berukuran 255 karakter',
            'gender.in' => 'Jenis kelamin harus berupa Laki-laki atau Perempuan',
            'desc.string' => 'Deskripsi harus berupa huruf',
            'profile_picture.image' => 'Foto profil harus berupa gambar',
            'profile_picture.mimes' => 'Foto profil harus berupa gambar (jpg, jpeg, png)',
            'profile_picture.max' => 'Foto profil maksimal berukuran 2MB',
            'cv.mimes' => 'CV harus berupa file gambar atau PDF',
            'cv.max' => 'CV maksimal berukuran 2MB',
            'field.in' => 'Bidang harus berupa ' . implode(', ', CourseType::getValues()),
            'phone.max' => 'Nomor telepon maksimal berukuran 20 karakter',
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
