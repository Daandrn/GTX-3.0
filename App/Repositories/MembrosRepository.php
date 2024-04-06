<?php declare(strict_types=1);

namespace App\Repository;

use App\Models\Membros;
use stdClass;

require __DIR__.'/../Models/Membros.php';

class MembrosRepository
{
    public function __construct(
        protected Membros $membrosModel,
    ) {
    }
    
    public function getAllMembers(): array|null
    {
        $membros = $this->membrosModel->select(
            fields: [
                'membros.nome', 
                'membros.nick', 
                'statusmembro.descricao as cargo_membro', 
                'canalstream.link_canal', 
                'canalstream.nickstream', 
                'plataformagame.descricao as plataforma_game'
            ],
            join: [
                ['statusmembro', 'status_solicit', 'left'],
                ['canalstream', 'id', 'left'],
                ['plataformagame', 'id', 'left'],
            ],
            where: [
                'status_solicit','in', '(1,4)',
                'ORDER BY membros.id DESC'
            ],
        );

        return !empty($membros) 
                ? $membros 
                : null;
    }

    public function loginSenhaMembro(string $nick): array|null
    {
        $membro = $this->membrosModel->select(
            fields: ['nome', 'nick', 'status_solicit', 'senha'],
            where: ['nick', '=', "'$nick'", 'AND status_solicit IN (0, 1, 4)']
        );
        
        return !empty($membro)
                ? $membro
                : null;
    }
}

$membrosRepository = new MembrosRepository($membrosModel);
