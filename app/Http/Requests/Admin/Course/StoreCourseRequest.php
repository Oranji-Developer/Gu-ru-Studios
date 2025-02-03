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

class StoreCourseRequest extends FormRequest
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
                'required',
                'exists:mentors,id'
            ],
            'title' => [
                'bail',
                'required',
                'string',
                'max:100'
            ],
            'desc' => [
                'bail',
                'required',
                'string',
            ],
            'capacity' => [
                'bail',
                'required',
                'integer',
                'min:1'
            ],
            'cost' => [
                'bail',
                'required',
            ],
            'disc' => [
                'bail',
                'required',
            ],
            'course_type' => [
                'bail',
                'required',
                Rule::in(CourseType::getValues())
            ],
            'class' => [
                'bail',
                Rule::when($this->input('course_type') !== CourseType::ABK->value, [
                    'required',
                    Rule::in(
                        $this->input('course_type') === CourseType::ACADEMIC->value
                            ? AcademicClass::getValues()
                            : ArtsClass::getValues()
                    )
                ])
            ],
            'thumbnail' => [
                'bail',
                'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048'
            ],
            'status' => [
                'bail',
                'required',
                Rule::in(StatusEnum::getValues())
            ],
            'start_date' => [
                'bail',
                'required',
                'date'
            ],
            'end_date' => [
                'bail',
                'required',
                'date',
                'after:start_date'
            ],
            'day' => [
                'bail',
                'required',
                'array',
                Rule::in(['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'])
            ],
            'start_time' => [
                'bail',
                'required',
                'date_format:H:i'
            ],
            'end_time' => [
                'bail',
                'required',
                'date_format:H:i',
                'after:start_time'
            ],
            'total_meet' => [
                'bail',
                'required',
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
            'start_time.required' => 'Waktu mulai harus diisi',
            'start_time.date_format' => 'Waktu mulai harus berupa format H:i',
            'end_time.required' => 'Waktu selesai harus diisi',
            'end_time.date_format' => 'Waktu selesai harus berupa format H:i',
            'end_time.after' => 'Waktu selesai harus setelah waktu mulai',
            'total_meet.required' => 'Total pertemuan harus diisi',
            'total_meet.integer' => 'Total pertemuan harus berupa angka',
            'total_meet.min' => 'Total pertemuan minimal 1',
            'mentor_id.required' => 'Mentor harus diisi',
            'mentor_id.exists' => 'Mentor tidak ditemukan',
            'title.required' => 'Judul harus diisi',
            'title.string' => 'Judul harus berupa huruf',
            'title.max' => 'Judul maksimal berukuran 100 karakter',
            'desc.required' => 'Deskripsi harus diisi',
            'desc.string' => 'Deskripsi harus berupa huruf',
            'capacity.required' => 'Kapasitas harus diisi',
            'capacity.integer' => 'Kapasitas harus berupa angka',
            'capacity.min' => 'Kapasitas minimal 1',
            'cost.required' => 'Biaya harus diisi',
            'disc.required' => 'Diskon harus diisi',
            'course_type.required' => 'Tipe kursus harus diisi',
            'course_type.in' => 'Tipe kursus tidak valid',
            'class.required' => 'Kelas harus diisi',
            'class.in' => 'Kelas tidak valid',
            'thumbnail.required' => 'Thumbnail harus diisi',
            'thumbnail.image' => 'Thumbnail harus berupa gambar',
            'thumbnail.max' => 'Thumbnail maksimal berukuran 2MB',
            'status.required' => 'Status harus diisi',
            'status.in' => 'Status tidak valid',
            'start_date.required' => 'Tanggal mulai harus diisi',
            'start_date.date' => 'Tanggal mulai harus berupa tanggal',
            'end_date.required' => 'Tanggal selesai harus diisi',
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
