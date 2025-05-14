<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class Repository
{
    /**
     * The Eloquent model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Repository constructor.
     *
     * @param string $modelClass  The model class or binding to resolve.
     */
    public function __construct(string $modelClass)
    {
        $this->model = app($modelClass);
    }

    /**
     * Get a single record by its primary key.
     *
     * @param  mixed  $id
     * @return Model|null
     */
    public function getOneById($id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Get multiple records by their primary keys.
     *
     * @param  array  $ids
     * @return Collection|Model[]
     */
    public function getByIds(array $ids): Collection
    {
        return $this->model->find($ids);
    }

    /**
     * Get all records for the model.
     *
     * @return Collection|Model[]
     */
    public function getAll(): Collection
    {
        return $this->model->all();
    }

    /**
     * Get the first record matching the given where condition.
     *
     * @param  mixed ...$params
     * @return Model|null
     */
    public function getFirstWhere(...$params): ?Model
    {
        return $this->model->firstWhere(...$params);
    }

    /**
     * Create a new record in the database.
     *
     * @param  array  $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }
}