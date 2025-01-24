<?php

namespace App\Trait;

trait UpdateHandleTrait
{
    public function handleUpdate($model, array $newData, array $fileFields = []): void
    {
        $diffData = array_diff_assoc($newData, $model->toArray());

        $diffData = array_filter($diffData, function ($value) {
            return $value !== null;
        });

        $diffData = array_filter($diffData, function ($value): bool {
            return !is_null($value);
        });

        if ($diffData) {
            foreach ($fileFields as $field) {
                if (isset($diffData[$field]) && $model->$field) {
                    $this->deleteFiles([$model->$field]);
                }
            }
            $model->update($diffData);

        }
    }
}
