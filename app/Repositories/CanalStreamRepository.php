<?php declare(strict_types=1);

namespace App\Repositories;

use App\DTO\UpdateCanalStreamDTO;
use App\Models\CanalStream;
use stdClass;

class CanalStreamRepository
{
    
    public function __construct(
        protected CanalStream $canalStreamModel,
    ) {
        //
    }

    /**
     * Carrega canal de stream
     * @param int $id id do membro
     * @return CanalStream Dados do canal de stream
     */
    public function getStream(int $id): CanalStream
    {
        $canalStream = $this->canalStreamModel->select();

        $canalStream->where('id', '=', $id);
        
        return $canalStream->first();
    }

    public function new(int $id): bool
    {
        $data = [
            'id'         => $id,
            'plataforma' => null,
            'link_canal' => null,
            'nick_stream' => null,
        ];
        
        return $this->canalStreamModel->insert($data);
    }

    // public function update(UpdateCanalStreamDTO $dto, ?int $id = null): stdClass|false
    // {
    //     $wasUpdated = $this->canalStreamModel->update(data: $dto->toArray(), id: $id, );

    //     if ($wasUpdated) {
    //         $streamUpdated = $this->canalStreamModel->select(
    //             where: ['id', '=', $id, ''],
    //         );
    //     }

    //     return !empty($wasUpdated)
    //             ? (object) $streamUpdated[0]
    //             : false;
    // }

    public function delete(int $id): bool
    {
        return $this->canalStreamModel->deleteOne($id);
    }
}
