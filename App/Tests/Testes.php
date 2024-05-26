<?php declare(strict_types=1);

namespace App\tests;

use App\Repositories\StreamChannelRepository;

require_once __DIR__ . '/../../Vendor/autoload.php';

class Testes
{
    public function teste()
    {
        $this->novoCanalStream();
    }

    private function novoCanalStream()
    {
        (new StreamChannelRepository())->newStream(999);
    }
}
