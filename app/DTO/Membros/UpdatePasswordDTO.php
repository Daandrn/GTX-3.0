<?php declare(strict_types=1);

namespace App\DTO\Membros;

class UpdatePasswordDTO
{
    public int    $id;
    public string $senha;

    public function __construct(object $data)
    {
        $this->id    = $data->id;
        $this->senha = (string) $data->senha;
    }

    public static function make(object $request): self
    {
        $data = (object) [
            'id'    => $request->id,
            'senha' => $request->senha,
        ];
        
        return new self($data);
    }

    public function toArray(): array
    {
        $array = [
            'id'    => $this->id,
            'senha' => $this->senha,
        ];
        
        return $array;
    }
}