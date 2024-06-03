<?php declare(strict_types=1);

namespace App\Enums;

require_once __DIR__ . '/../../Vendor/autoload.php';

enum StatusSolicit: int
{
    case STATUS_PENDENTE  = 0;
    case STATUS_MEMBRO    = 1;
    case STATUS_REJEITADO = 2;
    case STATUS_EXPULSO   = 3;
    case STATUS_ADM       = 4;
}
