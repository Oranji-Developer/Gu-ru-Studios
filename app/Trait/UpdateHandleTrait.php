<?php

namespace App\Trait;

trait UpdateHandleTrait
{
    public function diff(array $oldData, array $newData): array
    {
        return array_diff_assoc($newData, $oldData);
    }

    public function handleUpdate($model, array $newData, array $fileFields = []): bool
    {
        $diffData = $this->diff($model->toArray(), $newData);

        if ($diffData) {
            foreach ($fileFields as $field) {
                if (isset($diffData[$field]) && $model->$field) {
                    $this->deleteFiles([$model->$field]);
                }
            }

            $model->update($diffData);
            return true;
        }

        return false;
    }
}
