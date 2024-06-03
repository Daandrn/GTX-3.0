<?php declare(strict_types=1);

namespace App\Models;

use Vendor\Model\Model;

require_once __DIR__ . '/../../Vendor/autoload.php';

class RecuperaSenha extends Model
{
    public static function newInstance(): self
    {
        $fillable = [
            'member_id',
            'nick',
            'nova_senha',
            'solicit_senha',
            'data_solicit',
        ];
        
        return new RecuperaSenha('recuperasenha', $fillable);
    }
}
