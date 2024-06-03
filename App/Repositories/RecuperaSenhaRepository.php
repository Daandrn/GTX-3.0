<?php declare(strict_types=1);

namespace App\Repositories;

use App\DTO\SolicitUpdatePassword;
use App\Models\RecuperaSenha;
use stdClass;

require_once __DIR__ . '/../../Vendor/autoload.php';

class RecuperaSenhaRepository
{
    protected RecuperaSenha $recuperaSenha;

    public function __construct()
    {
        $this->recuperaSenha = RecuperaSenha::newInstance();
    }

    public function new(SolicitUpdatePassword $dto): bool
    {
        $wasCreated = $this->recuperaSenha->insert($dto->toArray());
        
        return $wasCreated;
    }

    public function getPendingSolicities(): array|null
    {
        $solicities = $this->recuperaSenha->select(
            fields: [
                'membros.nome',
                'recuperasenha.member_id',
                'recuperasenha.id',
                'recuperasenha.nick',
                'recuperasenha.data_solicit',
                'statussenha.descricao AS status_senha',
            ],
            join: [
                ['membros', 'id', 'inner', 'member_id'],
                ['statussenha', 'solicit_senha', 'left'],
            ],
            where: [
                'solicit_senha', '=', '1',
                'ORDER BY data_solicit ASC'
            ]
        );

        return !empty($solicities)
                ? $solicities
                : null;
    }

    public function getSolicityToMember(int $member_id): stdClass|false
    {
        $solicity = $this->recuperaSenha->select(
            where: ['member_id', '=', $member_id, 'and solicit_senha = 1 ORDER BY data_solicit DESC limit 1'],
        );

        return !empty($solicity)
                ? $solicity[0]
                : false;
    }

    public function updateStatusSolicity(int $id, int $status_solicit): bool
    {
        $wasUpdated = $this->recuperaSenha->update(
            ['solicit_senha' => $status_solicit],
            $id,
        );

        return $wasUpdated
                ? true
                : false;
    }
}
