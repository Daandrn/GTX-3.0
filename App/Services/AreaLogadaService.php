<?php declare(strict_types=1);

namespace App\Services;

use App\Models\StreamingPlatform;

require_once __DIR__ . '/../../Vendor/autoload.php';

class AreaLogadaService
{
    protected StreamingPlatform $streamingPlatformModel;

    public function __construct()
    {
        $this->streamingPlatformModel = StreamingPlatform::newInstance();
    }

    public function sessionExists(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (isset($_SESSION['nick'])) {
            return true;
        }

        session_regenerate_id();
        $_SESSION = [];
        session_destroy();

        return false;
    }

    function getStreamingPlatforms(): array|null
    {
        $platforms = $this->streamingPlatformModel->select();

        return !empty($platforms)
                ? $platforms
                : null;
    }
}
