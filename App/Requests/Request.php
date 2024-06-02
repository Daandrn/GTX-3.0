<?php declare(strict_types=1);

namespace App\Requests;

require_once __DIR__ . '/../../Vendor/autoload.php';

class Request
{
    protected array $request;
    
    protected function __construct()
    {
        $this->request = $_REQUEST;
    }
    
    public static function new(): object
    {
        $request = new self();
        
        return (object) $request->request;
    }

    public static function toArray(): array
    {
        $request = new self();

        return $request->request;
    }
}
