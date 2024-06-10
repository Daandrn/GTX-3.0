<?php declare(strict_types=1);

namespace App\Repositories;

use App\DTO\Membros\CreateMembroDTO;
use App\DTO\Membros\UpdateNickDTO;
use App\DTO\Membros\UpdatePasswordDTO;
use App\DTO\Membros\UpdateStatusMembroDTO;
use App\Models\Membro;
use App\Models\PlataformaGame;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use stdClass;

class MembroRepository
{
    
    public function __construct(
        protected Membro $membroModel,
    ) {
        //
    }

    public function memberExists(?string $nick = null, ?int $id = null): Collection
    {        
        if ($nick) {
            $memberExists = $this->membroModel->where('nick', '=', $nick);
        }

        if ($id) {
            $memberExists = $this->membroModel->where('id', '=', $id);
        }

        return $memberExists->get(['id', 'nick']);
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
                'status_membros.descricao as status_solicit',
            ],
        );

        $recruits->join('status_membros', 'status_membros.id', '=', 'status_solicit');
        $recruits->join('plataforma_game', 'plataforma_game.id', '=', 'membros.plataforma');

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
                'status_membros.descricao AS status_solicit',
            ],
        );

        $rejected->join('status_membros', 'status_membros.id', '=','status_solicit');
        $rejected->join('plataforma_game', 'plataforma_game.id', '=', 'membros.plataforma');

        $rejected->whereIn('status_solicit', [2, 3]);

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

    public function insert(CreateMembroDTO $dto): Membro
    {
        return $this->membroModel->create($dto->toArray());
    }

    public function updateStatusMember(UpdateStatusMembroDTO $dto): bool
    {
        $memberUpdated = $this->membroModel->findOrFail($dto->id);

        return $memberUpdated->update($dto->toArray());
    }

    public function updateNick(UpdateNickDTO $dto): Membro
    {
        $memberUpdated = $this->membroModel->findOrFail($dto->id);
        $wasUpdated = $memberUpdated->update($dto->toArray());

        if ($wasUpdated) {
            $nickUpdated = $this->membroModel->where('id', '=', $dto->id);
        }

        return $nickUpdated->first(['id', 'nick']);
    }

    public function updatePassword(UpdatePasswordDTO $dto): bool
    {
        $memberUpdated = $this->membroModel->findOrFail($dto->id);
        
        return $memberUpdated->update($dto->toArray());
    }

    public function delete(int $id): void
    {
        $deleted = $this->membroModel->findOrFail($id);
        $deleted->deleteOrFail();

        DB::commit();
    }
}
