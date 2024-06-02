<?php declare(strict_types=1);

namespace App\DTO\Membros;

require_once __DIR__.'/../../../Vendor/autoload.php';

class UpdateStatusMembroDTO
{
    public function __construct(
        public int $id,
        public int $status_solicit,
    ) {
    }

    public static function make(array $request): self
    {
        $id = (int) $request[2];
        $status_solicit = (int) $request[0];

        return new self(
            $id,
            $status_solicit,
        );
    }
}
