<?php declare(strict_types=1);

namespace App\Repositories;

use App\DTO\Membros\CreateMembroDTO;
use App\DTO\Membros\UpdateNickDTO;
use App\DTO\Membros\UpdatePasswordDTO;
use App\DTO\Membros\UpdateStatusMembroDTO;
use App\Models\Membro;
use App\Models\PlataformaGame;
use Illuminate\Database\Eloquent\Collection;
use stdClass;

class MembroRepository
{
    
    public function __construct(
        protected Membro $membroModel,
    ) {
        //
    }

    public function memberExists(?string $nick = null, ?int $id = null): Membro
    {
        if ($nick) {
            $memberExists = $this->membroModel->select('id', 'nick');
            $memberExists->where('nick', '=', $nick);
        }

        if ($id) {
            $memberExists = $this->membroModel->select('id', 'nick');
            $memberExists->where('id', '=', $id);
        }

        return $memberExists->first();
    }

    public function getAllMembers(): Collection
    {
        $membros = $this->membroModel->select(
            [   'membros.id',
                'membros.nome',
                'membros.nick',
                'status_membros.descricao as cargo_membro',
                'canal_stream.link_canal',
                'canal_stream.nick_stream',
                'plataforma_game.descricao as plataforma_game',
            ]
        );

        $membros->join('status_membros', 'status_solicit', '=', 'status_membros.id');
        $membros->leftJoin('canal_stream', 'membros.id', '=', 'canal_stream.membro_id');
        $membros->join('plataforma_game', 'membros.plataforma', '=', 'plataforma_game.id');

        $membros->whereIn('status_solicit', [1,4]);

        $membros->orderBy('status_solicit', 'desc');

        return $membros->get();
    }

    public function getAllRecruits(): Collection
    {
        $recruits = $this->membroModel->select(
            [
                'membros.id',
                'membros.nome',
                'membros.nick',
                'plataforma_game.descricao AS plataforma',
                'status_membros.descricao',
            ],
        );

        $recruits->leftJoin('status_membros', 'status_membros.id', 'status_solicit');
        $recruits->leftJoin('plataforma_game', 'plataforma_game.id', 'membros.plataforma');

        $recruits->whereIn('status_solicit', [0]);

        $recruits->orderBy('membros.id', 'asc');

        return $recruits->get();
    }

    public function getAllRejected(): Collection
    {
        $rejected = $this->membroModel->select(
            [
                'membros.id',
                'membros.nome',
                'membros.nick',
                'plataforma_game.descricao AS plataforma',
                'status_membros.descricao AS status_membros',
            ],
        );

        $rejected->leftJoin('status_membros', 'status_membros.id','status_solicit');
        $rejected->leftJoin('plataforma_game', 'plataforma_game.id', 'membros.plataforma');

        $rejected->whereIn('status_solicit', [2]);

        $rejected->orderBy('membros.id', 'asc');

        return $rejected->get();
    }

    public function memberWithStream(int $id): Membro
    {
        $membro = $this->membroModel->select(
            [
                'membros.id',
                'membros.nome',
                'membros.nick',
                'membros.status_solicit',
                'canal_stream.nick_stream',
                'canal_stream.link_canal',
                'canal_stream.plataforma',
            ],
        );

        $membro->leftJoin('canal_stream', 'canal_stream.membro_id', 'membros.id');

        $membro->where('membros.id', '=', $id);

        return $membro->first();
    }

    public function loginPasswordMember(string $nick): Membro
    {
        $loginPassword = $this->membroModel->where('nick', '=', $nick);
        $loginPassword->whereIn('status_solicit', [0, 1, 4]);

        return $loginPassword->firstOrFail(
            [
                'id',
                'nome',
                'nick',
                'status_solicit',
                'senha',
            ],
        );
    }

    public function insert(CreateMembroDTO $dto): stdClass|false
    {
        $insert = $this->membroModel->insert((array) $dto);

        if ($insert) {
            $newMember = $this->membroModel->select(
                fields: ['*'],
                where: ['id', '=', '(SELECT max(id) FROM membros)', 'limit 1'],
            );
        }

        return !empty($newMember)
                ? $newMember[0]
                : false;
    }

    public function updateStatusMember(UpdateStatusMembroDTO $dto): bool
    {
        return $this->membroModel->update(
            ['status_solicit' => $dto->status_solicit],
            $dto->id,
        );
    }

    public function updateNick(UpdateNickDTO $dto, int $id): stdClass|false
    {
        $wasUpdated = $this->membroModel->update($dto->toArray(), $id);

        if ($wasUpdated) {
            $nickUpdated = $this->membroModel->select(
                fields: ['id', 'nick'],
                where: ['id', '=', $id, 'limit 1'],
            );
        }

        return $wasUpdated
                ? $nickUpdated[0]
                : false;
    }

    public function updatePassword(UpdatePasswordDTO $dto, int $id): bool
    {
        $wasUpdated = $this->membroModel->update($dto->toArray(), $id);

        return $wasUpdated;
    }

    public function delete(int $id): bool
    {
        return $this->membroModel->deleteOne($id);
    }
}
