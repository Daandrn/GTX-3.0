<?php declare(strict_types=1);

namespace App\DTO\Membros;

class UpdateMembroDTO
{
    public function __construct(
        protected int $id,
        protected string $nome, 
        protected string $nick, 
        protected int $plataforma, 
        protected int $status_solicit,
        protected int $senha,
    ) {
    }

    public static function dto(object $request): self
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