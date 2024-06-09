<?php declare(strict_types=1);

namespace App\Repositories;

use App\DTO\SolicitUpdatePassword;
use App\Models\RecuperaSenha;
use stdClass;

class RecuperaSenhaRepository
{
    
    public function __construct(
        protected RecuperaSenha $recuperaSenha,
    ) {
        //
    }

    public function new(SolicitUpdatePassword $dto): bool
    {
        $wasCreated = $this->recuperaSenha->insert($dto->toArray());
        
        return $wasCreated;
    }

    public function getPendingSolicities(): array|null
    {
        $solicities = $this->recuperaSenha->select(
            [
                'membros.nome',
                'recupera_senha.membro_id',
                'recupera_senha.id',
                'recupera_senha.nick',
                'recupera_senha.created_at',
                'status_senha.descricao',
            ],
        );

        $solicities->join('membros', 'membros.id', 'recupera_senha.membro_id');
        $solicities->join('status_senha', 'status_senha.id', '=', 'recupera_senha.status_senha');

        $solicities->where('status_senha', '=', 1);

        $solicities->orderBy('created_at', 'asc');

        return $solicities->first();
    }

    public function getSolicityToMember(int $member_id)
    {
        $solicity = $this->recuperaSenha->where('membro_id', '=', $member_id, 'and solicit_senha = 1');

        $solicity->orderBy('created_at', 'desc');

        return $solicity->first();
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
