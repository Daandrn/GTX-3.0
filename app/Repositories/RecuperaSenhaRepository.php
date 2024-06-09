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
                'recupera_senha.member_id',
                'recupera_senha.id',
                'recupera_senha.nick',
                'recupera_senha.data_solicit',
                'status_senha.descricao AS status_senha',
            ],
        );

        $solicities->from();
        $solicities->join('membros', 'membros.id', 'member_id', 'inner');
        $solicities->join('status_senha', 'solicit_senha', 'left');
        $solicities->where('solicit_senha', '=', '1');
        $solicities->orderBy('data_solicit', 'asc');

        return $solicities->first();
    }

    public function getSolicityToMember(int $member_id): 
    {
        $solicity = $this->recuperaSenha->select();
        $solicity->from('');
        $solicity->where('member_id', '=', $member_id, 'and solicit_senha = 1');
        $solicity->orderBy('data_solicit', 'desc');

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
