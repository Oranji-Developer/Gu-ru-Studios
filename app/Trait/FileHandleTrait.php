<?php

namespace App\Trait;

use Illuminate\Support\Facades\Storage;

trait FileHandleTrait
{
    /**
     * Array of file configurations
     *
     * @var array<string>
     */
    private array $fileConfigs = [
        'profile_picture' => 'uploads/mentors/profile_picture',
        'cv' => 'uploads/mentors/cv',
        'thumbnail' => 'uploads/thumbnail'
    ];

    /**
     * Handle file upload
     *
     * @return void
     */
    function handle(): void
    {
        foreach ($this->fileConfigs as $field => $path) {
            if ($this->hasFile($field)) {
                $this->processAndStoreFile($field, $path);
            }
        }
    }

    /**
     * Handle multiple files upload
     *
     * @param string $field Field name (e.g., 'files')
     * @param string $path Storage path
     * @return void
     */
    function handleMultipleFiles(string $field, string $path): void
    {
        if ($this->hasFile($field)) {
            $files = $this->file($field);
            $uploadedFiles = [];

            foreach ($files as $key => $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs($path, $fileName, 'public');

                $uploadedFiles[$key] = [
                    'name' => $fileName,
                    'path' => $filePath
                ];
            }

            $this->merge([
                'files' => $uploadedFiles
            ]);
        }
    }

    /**
     * Process and store file
     *
     * @param string $field
     * @param string $path
     * @return void
     */
    private function processAndStoreFile(string $field, string $path): void
    {
        $file = $this->file($field);
        $fileName = time() . '_' . $file->hashName();
        $filePath = $file->storeAs($path, $fileName, 'public');

        $this->merge([
            $field => $filePath
        ]);
    }

    /**
     * Delete all files in the folder
     *
     * @param array<string>|null $fields
     * @return void
     */
    public function deleteFilesFolder(?array $fields = null): void
    {
        $fieldsToDelete = $fields ?? array_keys($this->fileConfigs);

        foreach ($fieldsToDelete as $field) {
            if (isset($this->$field) && Storage::disk('public')->exists($this->$field)) {
                Storage::disk('public')->delete($this->$field);
            }
        }
    }

    /**
     * Delete files
     *
     * @param array<string> $files
     * @return void
     */
    public function deleteFiles(array $files): void
    {
        foreach ($files as $file) {
            $this->deleteFile($file);
        }
    }

    /**
     * Delete file
     *
     * @param string|null $filePath
     * @return bool
     */
    public function deleteFile(?string $filePath): bool
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->delete($filePath);
        }

        return false;
    }
}
