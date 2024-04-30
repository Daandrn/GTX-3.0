<?php declare(strict_types=1);

namespace App\Services;

use App\Models\StreamingPlatform;

class AreaLogadaService
{
    protected StreamingPlatform $streamingPlatformModel;
    
    public function __construct()
    {
        require_once __DIR__.'/../Models/StreamingPlatform.php';
        
        $this->streamingPlatformModel = $streamingPlatformModel;
    }
    
    public function sessionExists(): bool
    {
        session_start();

        if (isset($_SESSION['nick'])) {
            return true;
        }

        session_regenerate_id();
        $_SESSION = [];
        session_destroy();

        return false;
    }

    function getStreamingPlatform(): array|null
    {
        $platforms = $this->streamingPlatformModel->select();
        
        return !empty($platforms)
                ? $platforms
                : null;
    }
}
