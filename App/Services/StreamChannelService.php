<?php declare(strict_types=1);

namespace App\Services;

use App\Repositories\StreamChannelRepository;

require_once __DIR__ . '/../../Vendor/autoload.php';

class StreamChannelService
{
    protected StreamChannelRepository $streamChannelRepository;

    public function __construct()
    {
        $this->streamChannelRepository = new StreamChannelRepository;
    }

    public function newChannel(int $id): void
    {
        $this->streamChannelRepository->newChannel($id);
    }
}
