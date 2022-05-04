<?php

namespace App\Services;

use App\Repositories\FileRepository;

class FileService extends BaseService
{
    public function __construct(FileRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAllByFirmId(string $firmId)
    {
        return $this->repo->getAllByFirmId($firmId);
    }
}
