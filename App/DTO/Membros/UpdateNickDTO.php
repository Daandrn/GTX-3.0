<?php declare(strict_types=1);

namespace App\DTO\Membros;

require_once __DIR__.'/../../../Vendor/autoload.php';

class UpdateNickDTO
{
    public string $nick;

    public function __construct(object $data)
    {
        $this->nick = $data->nick;
    }

    public static function make(object $request): self
    {
        $data = (object) [
            'nick' => $request->nick,
        ];

        return new Self($data);
    }

    public function toArray(): array
    {
        $array = [
            'nick' => $this->nick,
        ];

        return $array;
    }
}