<?php

namespace App\Services;

use App\Repositories\ServiceRepository;

class ServiceService extends BaseService
{
    public function __construct(ServiceRepository $repo)
    {
        $this->repo = $repo;
    }
}
