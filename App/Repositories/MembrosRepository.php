<?php declare(strict_types=1);

namespace App\Repositories;

use App\DTO\Membros\CreateMembroDTO;
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

    public function memberExists(string $nick): bool
    {
        $memberExists = $this->membrosModel->select(
            fields: ['id', 'nick'],
            where: ['nick', '=', "'$nick'", 'limit 1'],
        );

        return $memberExists
                ? true
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
                'canalstream.nickstream',
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
                'canalstream.nickstream',
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

        return $insert
                ? $newMember[0]
                : false;
    }

    public function update(UpdateStatusMembroDTO $dto): bool
    {
        return $this->membrosModel->update(
            id: $dto->id,
            data: ['status_solicit' => $dto->status_solicit],
        );
    }

    public function delete(int $id): bool
    {
        return $this->membrosModel->deleteOne($id);
    }
}
