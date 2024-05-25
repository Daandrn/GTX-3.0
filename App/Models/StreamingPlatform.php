<?php declare(strict_types=1);

namespace App\Models;

use Vendor\Model\Model;

require_once __DIR__ . '/../../Vendor/autoload.php';

class StreamingPlatform extends Model
{
    //
}

$fillable = [
    'id',
    'descricao',
];

$streamingPlatformModel = new StreamingPlatform('plataformastream', $fillable);
