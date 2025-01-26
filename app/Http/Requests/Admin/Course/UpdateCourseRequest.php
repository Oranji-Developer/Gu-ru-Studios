<?php

namespace App\Http\Requests\Admin\Course;

use App\Enum\Courses\AcademicClass;
use App\Enum\Courses\ArtsClass;
use App\Enum\Courses\CourseType;
use App\Enum\Courses\StatusEnum;
use App\Enum\Users\RoleEnum;
use App\Trait\FileHandleTrait;
use Carbon\Carbon;
use Illuminate\Validation\Validator;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCourseRequest extends FormRequest
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
            'mentor_id' => [
                'bail',
                'exists:mentors,id'
            ],
            'title' => [
                'bail',
                'string',
                'max:100'
            ],
            'desc' => [
                'bail',
                'string',
            ],
            'capacity' => [
                'bail',
                'integer',
                'min:1'
            ],
            'cost' => [
                'bail',
            ],
            'disc' => [
                'bail',
            ],
            'course_type' => [
                'bail',
                'required',
                Rule::in(CourseType::getValues())
            ],
            'class' => [
                'bail',
                'nullable',
                Rule::when($this->input('course_type') !== CourseType::ABK->value, [
                    Rule::in(
                        $this->input('course_type') === CourseType::ACADEMIC->value
                            ? AcademicClass::getValues()
                            : ArtsClass::getValues()
                    )
                ])
            ],
            'thumbnail' => [
                'bail',
                'nullable',
                Rule::when(
                    is_file($this->thumbnail),
                    ['image', 'mimes:jpg,jpeg,png', 'max:2048'],
                    ['string']
                )
            ],
            'status' => [
                'bail',
                Rule::in(StatusEnum::getValues())
            ],
            'start_date' => [
                'bail',
                'date'
            ],
            'end_date' => [
                'bail',
                'date',
                'after:start_date'
            ],
            'day' => [
                'bail',
                'array',
                Rule::in(['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'])
            ],
            'start_time' => [
                'bail',
                'date_format:H:i'
            ],
            'end_time' => [
                'bail',
                'date_format:H:i',
                'after:start_time'
            ],
            'total_meet' => [
                'bail',
                'integer',
                'min:1'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'day.required' => 'Hari harus diisi',
            'day.array' => 'Hari harus berupa array',
            'day.in' => 'Hari harus berupa nama hari',
            'start_time.date_format' => 'Waktu mulai harus berupa format H:i',
            'end_time.date_format' => 'Waktu selesai harus berupa format H:i',
            'end_time.after' => 'Waktu selesai harus setelah waktu mulai',
            'total_meet.integer' => 'Total pertemuan harus berupa angka',
            'total_meet.min' => 'Total pertemuan minimal 1',
            'mentor_id.exists' => 'Mentor tidak ditemukan',
            'title.string' => 'Judul harus berupa huruf',
            'title.max' => 'Judul maksimal berukuran 100 karakter',
            'desc.string' => 'Deskripsi harus berupa huruf',
            'capacity.integer' => 'Kapasitas harus berupa angka',
            'capacity.min' => 'Kapasitas minimal 1',
            'course_type.in' => 'Tipe kursus tidak valid',
            'class.in' => 'Kelas tidak valid',
            'thumbnail.image' => 'Thumbnail harus berupa gambar',
            'thumbnail.max' => 'Thumbnail maksimal berukuran 2MB',
            'status.in' => 'Status tidak valid',
            'start_date.date' => 'Tanggal mulai harus berupa tanggal',
            'end_date.date' => 'Tanggal selesai harus berupa tanggal',
            'end_date.after' => 'Tanggal selesai harus setelah tanggal mulai',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'start_time' => $this->input('start_time') ? Carbon::parse($this->input('start_time'))->format('H:i') : null,
            'end_time' => $this->input('end_time') ? Carbon::parse($this->input('end_time'))->format('H:i') : null,
        ]);
    }

    protected function passedValidation(): void
    {
        $this->handle();
    }

    public function getCourse(): array
    {
        return [
            'mentor_id' => $this->input('mentor_id'),
            'title' => $this->input('title'),
            'desc' => $this->input('desc'),
            'capacity' => $this->input('capacity'),
            'cost' => $this->input('cost'),
            'disc' => $this->input('disc'),
            'course_type' => $this->input('course_type'),
            'class' => $this->input('class'),
            'thumbnail' => $this->input('thumbnail'),
            'status' => $this->input('status'),
        ];
    }

    public function getSchedule(): array
    {
        return [
            'start_date' => Carbon::parse($this->input('start_date'))->format('Y-m-d'),
            'end_date' => Carbon::parse($this->input('end_date'))->format('Y-m-d'),
            'day' => implode(',', $this->input('day')),
            'start_time' => $this->input('start_time'),
            'end_time' => $this->input('end_time'),
            'total_meet' => $this->input('total_meet')
        ];
    }
}
