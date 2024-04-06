<?php declare(strict_types=1);

namespace App\Services;

use App\Repository\MembrosRepository;
require __DIR__.'/../Repositories/MembrosRepository.php';

class MembrosService
{
    public function __construct(
        protected MembrosRepository $membrosRepository,
    ) {
    }

    public function allMembers(): array|null
    {
        $membros = $this->membrosRepository->getAllMembers();

        return $membros;
    }
}

$membrosService = new MembrosService($membrosRepository);
