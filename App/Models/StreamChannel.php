<?php declare(strict_types=1);

namespace App\Models;

use Config\DataBase;
use PDO;
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
            'nickstream',
        ];
        
        return new StreamChannel('canalstream', $fillable);
    }
}
