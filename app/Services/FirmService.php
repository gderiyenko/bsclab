<?php

namespace App\Services;

use App\Repositories\FirmRepository;
use Illuminate\Support\Collection;

class FirmService extends BaseService
{
    public function __construct(FirmRepository $repo)
    {
        $this->repo = $repo;
    }

    public function all(): Collection
    {
        return $this->repo->all();
    }

    public function noActs()
    {
        return $this->repo->noActs();
    }
}
