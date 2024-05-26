<?php declare(strict_types=1);

namespace App\Models;

use Vendor\Model\Model;

require_once __DIR__ . '/../../Vendor/autoload.php';

class RecuperaSenha extends Model
{
    public static function newInstance(): self
    {
        $fillable = [
            'id',
            'nick',
            'novasenha',
            'solicit_senha',
            'data_solicit',
            'id_unico',
        ];
        
        return new RecuperaSenha('recuperasenha', $fillable);
    }
}
