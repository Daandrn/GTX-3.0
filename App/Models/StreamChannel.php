<?php declare(strict_types=1);

namespace App\Models;

use Vendor\Model\Model;

require_once __DIR__ . '/../../Vendor/autoload.php';

class StreamChannel extends Model
{
    public static function newInstance(): self
    {
        $fillable = [
            'id',
            'plataforma',
            'link_canal',
            'nick_stream',
        ];
        
        return new StreamChannel('canalstream', $fillable);
    }
}
