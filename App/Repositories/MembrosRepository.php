<?php declare(strict_types=1);

namespace App\Repositories;

use App\DTO\Membros\CreateMembroDTO;
use App\DTO\Membros\UpdateNickDTO;
use App\DTO\Membros\UpdatePasswordDTO;
use App\DTO\Membros\UpdateStatusMembroDTO;
use App\Models\Membros;
use stdClass;

require_once __DIR__ . '/../../Vendor/autoload.php';

class MembrosRepository
{
    protected Membros $membrosModel;

    public function __construct()
    { 
        $this->membrosModel = Membros::newInstance();
    }

    public function memberExists(?string $nick = null, ?int $id = null): stdClass|false
    {
        if ($nick) {
            $memberExists = $this->membrosModel->select(
                fields: ['id', 'nick'],
                where: ['nick', '=', "'$nick'", 'limit 1'],
            );
        }

        if ($id) {
            $memberExists = $this->membrosModel->select(
                fields: ['id', 'nick'],
                where: ['id', '=', "'$id'", 'limit 1'],
            );
        }

        return !empty($memberExists)
                ? $memberExists[0]
                : false;
    }

    public function getAllMembers(): array|null
    {
        $membros = $this->membrosModel->select(
            fields: [
                'membros.id',
                'membros.nome',
                'membros.nick',
                'statusmembro.descricao as cargo_membro',
                'canalstream.link_canal',
                'canalstream.nick_stream',
                'plataformagame.descricao as plataforma_game',
            ],
            join: [
                ['statusmembro', 'status_solicit', 'left'],
                ['canalstream', 'id', 'left'],
                ['plataformagame', 'id', 'left', 'plataforma'],
            ],
            where: [
                'status_solicit', 'in', '(1,4)',
                'ORDER BY membros.status_solicit DESC',
            ],
        );

        return !empty($membros)
                ? $membros
                : null;
    }

    public function getAllRecruits(): array|null
    {
        $recruits = $this->membrosModel->select(
            fields: [
                'membros.id',
                'membros.nome',
                'membros.nick',
                'plataformagame.descricao AS plataforma',
                'statusmembro.descricao AS status_membro',
            ],
            join: [
                ['statusmembro', 'status_solicit', 'left'],
                ['plataformagame', 'id', 'left', 'plataforma'],
            ],
            where: [
                'status_solicit', 'in', '(0)',
                'ORDER BY membros.id ASC',
            ],
        );

        return $recruits;
    }

    public function getAllRejected(): array|null
    {
        $rejected = $this->membrosModel->select(
            fields: [
                'membros.id',
                'membros.nome',
                'membros.nick',
                'plataformagame.descricao AS plataforma',
                'statusmembro.descricao AS status_membro',
            ],
            join: [
                ['statusmembro', 'status_solicit', 'left'],
                ['plataformagame', 'id', 'left', 'plataforma'],
            ],
            where: [
                'status_solicit', 'in', '(2,3)',
                'ORDER BY membros.id ASC',
            ],
        );

        return $rejected;
    }

    public function memberWithStream(int $id): stdClass|null
    {
        $membro = $this->membrosModel->select(
            fields: [
                'membros.id',
                'membros.nome',
                'membros.nick',
                'membros.status_solicit',
                'canalstream.nick_stream',
                'canalstream.link_canal',
                'canalstream.plataforma',
            ],
            join: [
                ['canalstream', 'id', 'inner'],
            ],
            where: ['id', '=', "$id", 'limit 1']
        );

        return !empty($membro)
                ? $membro[0]
                : null;
    }

    public function insert(CreateMembroDTO $dto): stdClass|false
    {
        $insert = $this->membrosModel->insert((array) $dto);

        if ($insert) {
            $newMember = $this->membrosModel->select(
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
        return $this->membrosModel->update(
            data: ['status_solicit' => $dto->status_solicit],
            id: $dto->id,
        );
    }

    public function updateNick(UpdateNickDTO $dto, int $id): stdClass|false
    {
        $wasUpdated = $this->membrosModel->update($dto->toArray(), $id);

        if ($wasUpdated) {
            $nickUpdated = $this->membrosModel->select(
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
        $wasUpdated = $this->membrosModel->update($dto->toArray(), $id);

        return $wasUpdated;
    }

    public function delete(int $id): bool
    {
        return $this->membrosModel->deleteOne($id);
    }
}
