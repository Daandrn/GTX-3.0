<?php declare(strict_types=1);

namespace App\DTO;

class UpdateCanalStreamDTO
{
    public int         $membro_id;
    public int|null    $plataforma;
    public string|null $link_canal;
    public string|null $nick_stream;

    protected function __construct(object $data)
    {
        $this->membro_id   = $data->membro_id;
        $this->plataforma  = is_numeric($data->plataforma) ? (int) $data->plataforma : null;
        $this->link_canal  = $data->link_canal;
        $this->nick_stream = $data->nick_stream;
    }

    public static function make(object $request): self
    {
        $data = (object) [
            'membro_id'   => $request->membro_id,
            'plataforma'  => $request->plataforma,
            'link_canal'  => $request->link_canal,
            'nick_stream' => $request->nick_stream,
        ];

        return new self($data);
    }

    public function toArray(): array
    {
        $array = [
            'membro_id'   => $this->membro_id,
            'plataforma'  => $this->plataforma,
            'link_canal'  => $this->link_canal,
            'nick_stream' => $this->nick_stream,
        ];

        return $array;
    }
}
