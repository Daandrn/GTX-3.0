<?php declare(strict_types=1);

namespace App\DTO\Membros;

use App\Enums\StatusSolicit;
use Illuminate\Support\Facades\Hash;

class CreateMembroDTO
{
    public string $nome;
    public string $nick;
    public string $plataforma;
    public int    $status_solicit;
    public string $senha;

    public function __construct(object $data) 
    {
        $this->nome           = $data->nome;
        $this->nick           = $data->nick;
        $this->plataforma     = $data->plataforma;
        $this->status_solicit = $data->status_solicit;
        $this->senha          = $data->senha;
    }

    public static function make(array $request): self
    {
        $data = (object) [
            'nome'           => $request['nome_recrut'],
            'nick'           => $request['nick_recrut'],
            'plataforma'     => $request['plataforma_recrut'],
            'status_solicit' => StatusSolicit::STATUS_PENDENTE->value,
            'senha'          => Hash::make('12345678'),
        ];
        
        return new self($data);
    }

    public function toArray(): array
    {
        $array = [
            'nome'           => $this->nome,
            'nick'           => $this->nick,
            'plataforma'     => $this->plataforma,
            'status_solicit' => $this->status_solicit,
            'senha'          => $this->senha,
        ];

        return $array;
    }
}
