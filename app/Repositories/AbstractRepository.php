<?php

namespace App\Repositories;

abstract class AbstractRepository
{
    /**
     * Get all from db
     *
     */
    public function getAll($with = [])
    {
        $query = $this->make($with);
        return $query->get()->toArray();
    }

    /**
     * Get by id
     *
     * @param int $id
     */
    public function getById($id, $with = [])
    {
        $query = $this->make($with);
        $data = $query->find($id);
        if($data) {
            return $data->toArray();
        } else {
            return null;
        }
    }


    /**
     * Make query to eager load related tables
     *
     * @param string $key
     * @param string $value
     */

    public function make(array $with = [])
    {
        return $this->model->with($with);
    }

}
