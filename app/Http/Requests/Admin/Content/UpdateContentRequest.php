<?php

namespace App\Http\Requests\Admin\Content;

use App\Enum\Contents\ContentType;
use App\Enum\Users\RoleEnum;
use App\Trait\FileHandleTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContentRequest extends FormRequest
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
                'string',
                'max:100'
            ],
            'desc' => [
                'bail',
                'string',
            ],
            'thumbnail' => [
                'bail',
                'file',
                'mimes:jpg,jpeg,png',
                'max:2048'
            ],
            'type' => [
                'bail',
                Rule::in(ContentType::getValues())
            ],
            'link' => [
                'bail',
                'url'
            ],
            'files.*.file' => [
                'bail',
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
            'title.string' => 'Judul harus berupa huruf',
            'title.max' => 'Judul maksimal berukuran 100 karakter',
            'desc.string' => 'Deskripsi harus berupa huruf',
            'link.url' => 'Link harus berupa URL',
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

    /**
     * Get files
     *
     *
     * @return array
     */
    public function getFiles(): array
    {
        if (!$this->input('files')) {
            return [];
        }

        return $this->input('files');
    }
}
