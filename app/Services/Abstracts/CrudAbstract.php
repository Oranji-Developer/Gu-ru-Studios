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
    public function store($request): mixed
    {
        return null;
    }

    /*
     * Default implementation of update method
     *
     * @param $request
     * @param $id
     * @return bool
     * */
    public function update($request, ?int $id = null): mixed
    {
        return null;
    }


    /*
     * Default implementation of destroy method
     *
     * @param $id
     * @return bool
     * */
    public function destroy($id): mixed
    {
        return null;
    }
}
