<?php declare(strict_types=1);

namespace App\Repository;

use App\Models\Membros;
require __DIR__.'/../Models/Membros.php';

class MembrosRepository
{
    public function __construct(
        protected Membros $model,
    ) {
    }
    
    public function getAll(): array|null
    {
        $membros = $this->model->select(['status_solicit','in', '(1,4)','ORDER BY id DESC']);

        return !empty($membros) ? $membros : null;
    }
}

$repository = new MembrosRepository($model);
