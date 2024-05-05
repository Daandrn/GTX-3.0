<?php declare(strict_types=1);

namespace App\Models;

use PDO;
use Vendor\Model\Model;

use function Config\connection;

require_once __DIR__ . '/../../Vendor/Model/Model.php';

class StreamChannel extends Model
{
    public function new(int $id): bool
    {
        $sql = "INSERT INTO canalstream VALUES (:id, null, null, null)";
        $canalstream = connection()->prepare($sql);
        $canalstream->bindParam(':id', $id, PDO::PARAM_INT);

        return $canalstream->execute();
    }
}

$fillable = [
    'id',
    'plataforma',
    'link_canal',
    'nickstream',
];

$streamChannelModel = new StreamChannel('canalstream', $fillable);
