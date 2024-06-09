<?php declare(strict_types=1);

namespace App\Requests;

use Exception;

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

    public static function ajax(): object
    {
        $request = file_get_contents('php://input');

        if (!json_validate($request)) {
            throw new Exception("Corpo da requisição Ajax inválida. Corpo esperado: Json.");
        }
        
        $request = json_decode($request, false);

        return $request;
    }

    public static function toArray(): array
    {
        $request = new self();

        return $request->request;
    }
}
