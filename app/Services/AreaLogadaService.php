<?php declare(strict_types=1);

namespace App\Services;

use App\Models\PlataformaStream;
use Illuminate\Database\Eloquent\Collection;

class AreaLogadaService
{
    public function __construct(
        protected PlataformaStream $plataformaStreamModel,
    ) {
        //
    }

    public function sessionExists(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['nick'])) {
            return true;
        }

        session_regenerate_id();
        $_SESSION = [];
        session_destroy();

        return false;
    }

    function getPlataformaStreams(): Collection|null
    {
        $platforms = $this->plataformaStreamModel->select()->get();

        return $platforms->isNotEmpty()
                ? $platforms
                : null;
    }
}
