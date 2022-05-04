<?php

namespace App\Services;

use App\Repositories\TemplateRepository;

class TemplateService extends BaseService
{
    public function __construct(TemplateRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAllByType(string $type)
    {
        return $this->repo->getAllByType($type);
    }
}
