<?php

namespace App\Http\Requests\Admin\Content;

use App\Enum\Contents\ContentType;
use App\Enum\Users\RoleEnum;
use App\Trait\FileHandleTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContentRequest extends FormRequest
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
                'max:100'
            ],
            'desc' => [
                'bail',
                'required',
                'string',
            ],
            'thumbnail' => [
                'bail',
                'required',
                'file',
                'mimes:jpg,jpeg,png',
                'max:2048'
            ],
            'type' => [
                'bail',
                'required',
                Rule::in(ContentType::getValues())
            ],
            'link' => [
                'bail',
                'nullable',
                'url'
            ],
            'files.*.file' => [
                'bail',
                'required',
                'file',
                'mimes:jpg,jpeg,png',
                'max:2048'
            ],
        ];
    }

    protected function passedValidation(): void
    {
        $this->handle();
        $this->handleMultipleFiles('files', 'uploads/contents');
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul wajib diisi',
            'title.string' => 'Judul harus berupa huruf',
            'title.max' => 'Judul maksimal berukuran 100 karakter',
            'desc.required' => 'Deskripsi wajib diisi',
            'desc.string' => 'Deskripsi harus berupa huruf',
            'type.required' => 'Tipe wajib diisi',
            'link.url' => 'Link harus berupa URL',
            'files.*.file.required' => 'File wajib diisi',
            'files.*.file.file' => 'File harus berupa file',
            'files.*.file.mimes' => 'File harus berupa file gambar (jpg, jpeg, png)',
            'files.*.file.max' => 'File maksimal berukuran 2MB',
        ];
    }

    public function getData(): array
    {
        return [
            'title' => $this->title,
            'desc' => $this->desc,
            'type' => $this->type,
            'link' => $this->link,
            'thumbnail' => $this->input('thumbnail')
        ];
    }

    public function getFiles(): array
    {
        return $this->input('files');
    }
}
