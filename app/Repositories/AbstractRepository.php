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
     * Find many entities by key value (Select * key=value)
     *
     * @param string $key
     * @param string $value
     */
    public function getManyBy($key, $value, array $with = [])
    {
        return $this->make($with)->where($key, '=', $value)->get()->toArray();
    }

    public function getAllByIds($ids, $with = array())
    {
        $query = $this->make($with);
        $data = $query->whereIn('id',$ids)->get()->toArray();
        return $data;
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
