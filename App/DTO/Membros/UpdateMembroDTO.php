<?php declare(strict_types=1);

namespace App\DTO\Membros;

require_once __DIR__.'/../../../Vendor/autoload.php';

class UpdateMembroDTO
{
    public function __construct(
        public int    $id,
        public string $nome,
        public string $nick,
        public int    $plataforma,
        public int    $status_solicit,
        public int    $senha,
    ) {
    }

    public static function make(object $request): self
    {
        return new self(
            $request->id,
            $request->nome,
            $request->nick,
            $request->plataforma,
            $request->status_solicit,
            $request->senha,
        );
    }
}
