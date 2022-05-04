<?php

namespace App\Repositories;

use App\Models\InvoiceServices;

class InvoiceServicesRepository extends BaseRepository
{
    /**
     * Repo Constructor
     * Override to clarify typehinted model.
     *
     * @param InvoiceServices $model Repo DB ORM Model
     */
    public function __construct(InvoiceServices $model)
    {
        $this->model = $model;
    }
}
