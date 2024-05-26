<?php declare(strict_types=1);

namespace Vendor\Helpers;

use Exception;
use Vendor\Routes\Route;

require_once __DIR__.'/../autoload.php';

class Redirect
{
    /**
     * Realiza redirecionamento para as rotas definidas.
     * @param string $classMethod Deve receber a classe e metodo para onde será redirecionado no padrão "Class.method".
     */
    public static function to(?string $route = null, ?string $classMethod = null, ?array $errors = null, ?array $data = null)
    {   
        if ($route) {
            header("Location: /{$route}");
            return;
        }

        if (
            !$classMethod
            || !preg_match('/\A\w{1,}\.\w{1,}\z/', $classMethod)
            || strlen($classMethod) < 7
        ) {
            throw new Exception("Classe ou metodo inválidos: {$classMethod}");
        }

        $classMethod = explode('.', $classMethod);
        $class  = "App\Controllers\\".$classMethod[0];
        $method = $classMethod[1];

        return Route::redirection($class, $method, $errors, $data);
    }
}
