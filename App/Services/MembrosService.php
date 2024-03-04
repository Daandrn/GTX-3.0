<?php declare(strict_types=1);

namespace App\Services;

use App\Repository\MembrosRepository;
require __DIR__.'/../Repositories/MembrosRepository.php';

class MembrosService
{
    public function __construct(
        protected MembrosRepository $repository,
    ) {
    }

    public function all(): array|null
    {
        $membros = $this->repository->getAll();

        return $membros;
    }
}

$service = new MembrosService($repository);
