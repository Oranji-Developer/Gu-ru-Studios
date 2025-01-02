<?php

namespace App\Services\Interfaces;

interface CrudInterface
{
    public function store($request): bool;

    public function update($request, ?int $id = null): bool;

    public function destroy($id): bool;
}
