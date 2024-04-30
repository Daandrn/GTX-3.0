<?php declare(strict_types=1);

namespace App\DTO\Membros;

class CreateMembroDTO
{
    protected static const STATUS_PENDENTE = 0;
    
    public function __construct(
        protected string $nome, 
        protected string $nick, 
        protected string $plataforma, 
        protected int    $status_solicit,
        protected string $senha,
    ) {
    }

    public static function make(array $request): self
    {
        return new self(
            $request['nome_recrut'],
            $request['nick_recrut'],
            $request['plataforma_recrut'],
            self::STATUS_PENDENTE,
            password_hash('123456', PASSWORD_BCRYPT),
        );
    }
}