<?php

namespace App\Services\Abstracts;

use App\Services\Interfaces\CrudInterface;

abstract class CrudAbstract implements CrudInterface
{
    /*
     * Default implementation of store method
     *
     * @param $request
     * @return bool
     * */
    public function store($request): bool
    {
        return false;
    }

    /*
     * Default implementation of update method
     *
     * @param $request
     * @param $id
     * @return bool
     * */
    public function update($request, ?int $id = null): bool
    {
        return false;
    }


    /*
     * Default implementation of destroy method
     *
     * @param $id
     * @return bool
     * */
    public function destroy($id): bool
    {
        return false;
    }
}
