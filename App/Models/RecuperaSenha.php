<?php declare(strict_types=1);

namespace App\Models;

use Vendor\Model\Model;

require_once __DIR__.'/../../Vendor/Model/Model.php';

class RecuperaSenha extends Model
{
    //
}

$fillable = [
    'id', 
    'nick', 
    'novasenha', 
    'solicit_senha', 
    'data_solicit',
    'id_unico',
];

$recuperaSenha = new RecuperaSenha('recuperasenha', $fillable);
