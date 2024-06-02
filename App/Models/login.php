<?php declare(strict_types=1);

namespace App\Models;

use stdClass;
use Vendor\Model\Model;

require_once __DIR__ . '/../../Vendor/autoload.php';

class Login extends Model
{
    public static function newInstance(): self
    {
        $fillable = [
            'nome',
            'nick',
            'plataforma',
            'status_solicit',
            'senha',
        ];

        return new Login('membros', $fillable);
    }

    public function loginPasswordMember(string $nick): stdClass|null
    {
        $membro = $this->select(
            fields: [
                'id',
                'nome',
                'nick',
                'status_solicit',
                'senha',
            ],
            where: ['nick', '=', "'$nick'", 'AND status_solicit IN (0, 1, 4) limit 1'],
        );

        return !empty($membro)
            ? $membro[0]
            : null;
    }
}
