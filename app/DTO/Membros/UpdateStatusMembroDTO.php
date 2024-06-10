<?php declare(strict_types=1);

namespace App\DTO\Membros;
use App\Http\Requests\Request;

class UpdateStatusMembroDTO
{
    public int $id;

    public int $status_solicit;

    public function __construct(object $data) 
    {
        $this->id             = $data->id;
        $this->status_solicit = $data->status_solicit;
    }

    public static function make(array $request): self
    {        
        $data = (object) [
            'id'             => (int) $request[2],
            'status_solicit' => (int) $request[0],
        ];

        return new self($data);
    }

    public function toArray(): array
    {
        $array = [
            'id'             => $this->id,
            'status_solicit' => $this->status_solicit,
        ];

        return $array;
    }
}
