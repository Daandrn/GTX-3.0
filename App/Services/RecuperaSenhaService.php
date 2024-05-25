<?php declare(strict_types=1);

namespace App\Services;

use App\Repositories\RecuperaSenhaRepository;

require_once __DIR__ . '/../../Vendor/autoload.php';

class RecuperaSenhaService
{
    protected RecuperaSenhaRepository $recuperaSenhaRepository;

    public function __construct()
    {
        $this->recuperaSenhaRepository = new RecuperaSenhaRepository;
    }

    public function pendingSolicities(): array|null
    {
        return $this->recuperaSenhaRepository->getPendingSolicities();
    }
}
