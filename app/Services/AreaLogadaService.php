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
        if (!session()->isStarted()) {
            session()->start();
        }

        if (session()->has('nick')) {
            return true;
        }

        session()->invalidate();
        session()->flush();

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
