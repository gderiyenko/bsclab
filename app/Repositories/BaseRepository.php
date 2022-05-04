<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class BaseRepository implements BaseInterface
{
    public $sortBy = 'name';
    public $sortOrder = 'asc';
    protected $model;

    /**
     * Repo Constructor
     * Override to clarify typehinted model.
     *
     * @param Model $model Repo DB ORM Model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all instances of model.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model
            ->orderBy($this->sortBy, $this->sortOrder)
            ->get();
    }

    /**
     * Get all instances of model.
     *
     * @return Collection
     */
    public function allWithTrashed(): Collection
    {
        return $this->model
            ->orderBy($this->sortBy, $this->sortOrder)
            ->withTrashed()->get();
    }

    /**
     * Create a new record in the database.
     *
     * @param array $data
     *
     * @return model
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update record in the database and get data back.
     *
     * @param string $id
     * @param array  $data
     *
     * @return bool
     */
    public function update(string $id, array $data): bool
    {
        $query = $this->model->where('id', $id);
        return $query->update($data);
    }

    /**
     * Remove record from the database.
     *
     * @param string $id
     *
     * @return bool
     */
    public function destroy(string $id): bool
    {
        $this->model->destroy($id);
        return true;
    }

    /**
     * Show the record with the given id.
     *
     * @param string $id
     *
     * @return model
     */
    public function findById(string $id)
    {
        return $this->model->find($id);
    }

    /**
     * Show the record with the given id.
     *
     * @param string $id
     *
     * @return model
     */
    public function findByIdWithTrashed(string $id)
    {
        return $this->model->withTrashed()->find($id);
    }

    /**
     * Get the associated model.
     *
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * Set the associated model.
     *
     * @param $model
     *
     * @return $this
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
        return true;
    }

    /**
     * Get count of model.
     *
     * @return int
     */
    public function count(): int
    {
        return $this->model->count();
    }

    public function findByInvoiceId(string $invoiceId)
    {
        return $this->model->where('invoice_id', $invoiceId)->get();
    }
}
