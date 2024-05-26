<?php declare(strict_types=1);

namespace App\Models;

use Vendor\Model\Model;

require_once __DIR__ . '/../../Vendor/autoload.php';

class StreamingPlatform extends Model
{
    public static function newInstance(): self
    {
        $fillable = [
            'id',
            'descricao',
        ];
        
        return new StreamingPlatform('plataformastream', $fillable);     
    }
}
