<?php

namespace App\Http\Requests\Admin\Event;

use App\Enum\Courses\AcademicClass;
use App\Enum\Courses\ArtsClass;
use App\Enum\Courses\CourseType;
use App\Enum\Courses\StatusEnum;
use App\Enum\Users\RoleEnum;
use App\Trait\FileHandleTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreEventRequest extends FormRequest
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
            'status' => [
                'bail',
                'required',
                Rule::in(StatusEnum::getValues()),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul harus diisi',
            'title.string' => 'Judul harus berupa huruf',
            'title.max' => 'Judul maksimal 100 karakter',
            'thumbnail.required' => 'Thumbnail harus diisi',
            'thumbnail.image' => 'Thumbnail harus berupa gambar',
            'thumbnail.mimes' => 'Thumbnail harus berupa gambar dengan format jpeg, png, jpg',
            'thumbnail.max' => 'Ukuran thumbnail maksimal 2MB',
            'desc.required' => 'Deskripsi harus diisi',
            'desc.string' => 'Deskripsi harus berupa huruf',
            'desc.max' => 'Deskripsi maksimal 255 karakter',
            'disc.required' => 'Diskon harus diisi',
            'disc.numeric' => 'Diskon harus berupa angka',
            'disc.between' => 'Diskon harus diantara 0 sampai 9999.99',
            'course_type.required' => 'Tipe kursus harus diisi',
            'course_type.in' => 'Tipe kursus tidak valid',
            'class.required' => 'Kelas harus diisi',
            'class.in' => 'Tipe kelas tidak valid',
            'start_date.required' => 'Tanggal mulai harus diisi',
            'start_date.date' => 'Tanggal mulai harus berupa tanggal',
            'end_date.required' => 'Tanggal selesai harus diisi',
            'end_date.date' => 'Tanggal selesai harus berupa tanggal',
            'status.required' => 'Status harus diisi',
        ];
    }

    protected function passedValidation(): void
    {
        $this->handle();
    }

    public function getData(): array
    {
        return [
            'title' => $this->input('title'),
            'thumbnail' => $this->input('thumbnail'),
            'desc' => $this->input('desc'),
            'disc' => $this->input('disc'),
            'course_type' => $this->input('course_type'),
            'class' => $this->input('class'),
            'start_date' => $this->input('start_date'),
            'end_date' => $this->input('end_date'),
            'status' => $this->input('status'),
        ];
    }
}
