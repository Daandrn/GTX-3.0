<?php declare(strict_types=1);

namespace App\DTO\Membros;

require_once __DIR__.'/../../../Vendor/autoload.php';

class UpdatePasswordDTO
{
    public string $senha;

    public function __construct(object $data)
    {
        $this->senha = $data->senha;
    }

    public static function make(object $request): self
    {
        $data = (object) [
            'senha' => $request->senha,
        ];
        
        return new self($data);
    }

    public function toArray(): array
    {
        $array = [
            'senha' => $this->senha,
        ];
        
        return $array;
    }
}