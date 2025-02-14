<?php

namespace App\Services\Interfaces;

use SebastianBergmann\Type\MixedType;

interface CrudInterface
{
    public function store($request): mixed;

    public function update($request, ?int $id = null): mixed;

    public function destroy($id): mixed;
}
