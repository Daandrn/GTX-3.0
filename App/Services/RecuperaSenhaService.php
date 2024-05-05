<?php declare(strict_types=1);

namespace App\Services;

use App\Repositories\RecuperaSenhaRepository;

class RecuperaSenhaService
{
    protected RecuperaSenhaRepository $recuperaSenhaRepository;

    public function __construct()
    {
        require_once __DIR__ . '/../Repositories/RecuperaSenhaRepository.php';

        $this->recuperaSenhaRepository = new RecuperaSenhaRepository;
    }

    public function pendingSolicities(): array|null
    {
        return $this->recuperaSenhaRepository->getPendingSolicities();
    }
}
