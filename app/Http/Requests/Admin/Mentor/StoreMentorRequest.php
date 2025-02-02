<?php

namespace App\Http\Requests\Admin\Mentor;

use App\Enum\Courses\CourseType;
use App\Enum\Users\GenderEnum;
use App\Enum\Users\RoleEnum;
use App\Trait\FileHandleTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMentorRequest extends FormRequest
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
                'required',
                'string',
                'max:100'
            ],
            'address' => [
                'bail',
                'required',
                'string',
                'max:255'
            ],
            'gender' => [
                'bail',
                'required',
                Rule::in(GenderEnum::getValues())
            ],
            'desc' => [
                'bail',
                'required',
                'string',
            ],
            'profile_picture' => [
                'bail',
                'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048'
            ],
            'cv' => [
                'bail',
                'required',
                'mimes:jpg,jpeg,png,pdf',
                'max:2048'
            ],
            'portfolio' => [
                'bail',
                'required',
                'string'
            ],
            'field' => [
                'bail',
                'required',
                Rule::in(CourseType::getValues())
            ],
            'phone' => [
                'bail',
                'required',
                'string',
                'max:20'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama harus diisi',
            'name.string' => 'Nama harus berupa huruf',
            'name.max' => 'Nama maksimal berukuran 100 karakter',
            'address.required' => 'Alamat harus diisi',
            'address.string' => 'Alamat harus berupa huruf',
            'address.max' => 'Alamat maksimal berukuran 255 karakter',
            'gender.required' => 'Jenis kelamin harus diisi',
            'gender.in' => 'Jenis kelamin harus berupa Laki-laki atau Perempuan',
            'desc.required' => 'Deskripsi harus diisi',
            'desc.string' => 'Deskripsi harus berupa huruf',
            'profile_picture.required' => 'Foto profil harus diisi',
            'profile_picture.image' => 'Foto profil harus berupa gambar',
            'profile_picture.mimes' => 'Foto profil harus berupa gambar (jpg, jpeg, png)',
            'profile_picture.max' => 'Foto profil maksimal berukuran 2MB',
            'cv.required' => 'CV harus diisi',
            'cv.mimes' => 'CV harus berupa file gambar atau PDF',
            'cv.max' => 'CV maksimal berukuran 2MB',
            'portfolio.required' => 'Portfolio harus diisi',
            'field.required' => 'Bidang harus diisi',
            'field.in' => 'Bidang harus berupa ' . implode(', ', CourseType::getValues()),
            'phone.required' => 'Nomor telepon harus diisi',
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
            'phone' => $this->input('phone'),
        ];
    }
}
