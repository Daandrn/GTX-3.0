<?php declare(strict_types=1);

namespace App\Repositories;

use App\DTO\UpdateCanalStreamDTO;
use App\Models\CanalStream;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
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
     * @return Collection Dados do canal de stream
     */
    public function getStream(int $id): Collection
    {
        $canalStream = $this->canalStreamModel->where('id', '=', $id);
        
        return $canalStream->get();
    }

    public function new(int $id): bool
    {
        $data = [
            'membro_id'   => $id,
            'plataforma'  => null,
            'link_canal'  => null,
            'nick_stream' => null,
        ];
        
        return $this->canalStreamModel->insert($data);
    }

    public function update(UpdateCanalStreamDTO $dto): CanalStream
    {
        $canalStream = $this->canalStreamModel->findOrFail($dto->membro_id);
        $wasUpdated = $canalStream->update($dto->toArray());

        if ($wasUpdated) {
            $streamUpdated = $this->canalStreamModel->where('id', '=', $dto->membro_id);
        }

        return $streamUpdated->first();
    }

    public function delete(int $id): void
    {
        DB::beginTransaction();
        
        $streamDeleted = $this->canalStreamModel->findOrFail($id);
        $streamDeleted->deleteOrFail();
    }
}
