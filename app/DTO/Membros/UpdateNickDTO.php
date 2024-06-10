<?php declare(strict_types=1);

namespace App\DTO\Membros;

class UpdateNickDTO
{
    public int    $id;
    public string $nick;

    public function __construct(object $data)
    {
        $this->id   = $data->id;
        $this->nick = $data->nick;
    }

    public static function make(object $request): self
    {
        $data = (object) [
            'id'   => $request->id,
            'nick' => $request->nick,
        ];

        return new Self($data);
    }

    public function toArray(): array
    {
        $array = [
            'id'   => $this->id,
            'nick' => $this->nick,
        ];

        return $array;
    }
}