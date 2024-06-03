<?php declare(strict_types=1);

namespace App\Enums;

require_once __DIR__ . '/../../Vendor/autoload.php';

enum StatusNovaSenha : int 
{
    case STATUS_APROVADO   = 0;
    case STATUS_SOLICITADO = 1;
    case STATUS_REPROVADO  = 2;
}
