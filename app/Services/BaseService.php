<?php

namespace App\Services;

abstract class BaseService
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->latest()->get();
    }

    public function getPaginate($limit, $conditions = [])
    {
        $query = $this->model->query();

        foreach ($conditions as $condition) {
            if (count($condition) === 3) {
                [$column, $operator, $value] = $condition;

                if (strtolower($operator) === 'in') {
                    $query->whereIn($column, $value);
                } else {
                    $query->where($column, $operator, $value);
                }
            }
        }

        return $query->latest()->paginate($limit);
    }

    public function store($data)
    {
        return $this->model->create($data);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function update($model, $data)
    {
        $model->update($data);
        return $model;
    }

    public function query()
    {
        return $this->model->query();
    }

    public function destroy($id)
    {
        return $this->model->find($id)?->delete();
    }

    public function sum($column, $conditions = [])
    {
        $query = $this->model->query();

        foreach ($conditions as $condition) {
            if (count($condition) === 3) {
                [$column, $operator, $value] = $condition;

                if (strtolower($operator) === 'in') {
                    $query->whereIn($column, $value);
                } else {
                    $query->where($column, $operator, $value);
                }
            }
        }

        return $query->sum($column);
    }

    public function count($conditions = [])
    {
        $query = $this->model->query();

        foreach ($conditions as $condition) {
            if (count($condition) === 3) {
                [$column, $operator, $value] = $condition;

                if (strtolower($operator) === 'in') {
                    $query->whereIn($column, $value);
                } else {
                    $query->where($column, $operator, $value);
                }
            }
        }

        return $query->count();
    }
}
