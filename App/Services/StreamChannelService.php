<?php declare(strict_types=1);

namespace App\Services;

use App\Repositories\StreamChannelRepository;

class StreamChannelService
{
    protected StreamChannelRepository $streamChannelRepository;
    
    public function __construct()
    {
        require __DIR__.'/../Repositories/StreamChannelRepository.php';

        $this->streamChannelRepository = new StreamChannelRepository;
    }

    public function newChannel(int $id): void
    {
        $this->streamChannelRepository->newChannel($id);
    }
}
