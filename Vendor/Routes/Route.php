<?php declare(strict_types=1);

namespace Vendor\Routes;

use Exception;

final class Route
{  
    private static function url(): string
    {
        $url = explode('/' , $_SERVER['REQUEST_URI']);

        return $url[1];
    }

    public static function get(array $route, string $class, string $method)
    {
        if (! self::getRequestVerify()) {
            return;
        }

        require __DIR__."/../../{$class}.php";

        if (! class_exists($class)) {
            throw new Exception("A classe utilizada não existe: {$class}");
        }

        if (! method_exists($class, $method)) {
            throw new Exception("O metodo utilizado não existe: {$method}. Da classe: {$class}");
        }

        return self::redirectGet($route, $class, $method);
    }

    public static function post(array $route, string $class, string $method)
    {
        if (! self::postRequestVerify()) {
            return;
        }

        require __DIR__."/../../{$class}.php";

        if (! class_exists($class)) {
            throw new Exception("A classe utilizada não existe: {$class}");
        }

        if (! method_exists($class, $method)) {
            throw new Exception("O metodo utilizado não existe: {$method}");
        }

        return self::redirectPost($route, $class, $method);
    }

    public static function put(array $route, string $class, string $method)
    {
        if (! self::postRequestVerify()) {
            return;
        }

        if (! class_exists($class)) {
            throw new Exception("A classe utilizada não existe: {$class}");
        }

        if (! method_exists($class, $method)) {
            throw new Exception("O metodo utilizado não existe: {$method}");
        }

        return self::redirectPost($route, $class, $method);
    }

    public static function patch(array $route, string $class, string $method)
    {
        if (! self::postRequestVerify()) {
            return;
        }

        if (! class_exists($class)) {
            throw new Exception("A classe utilizada não existe: {$class}");
        }

        if (! method_exists($class, $method)) {
            throw new Exception("O metodo utilizado não existe: {$method}");
        }

        return self::redirectPost($route, $class, $method);
    }

    public static function delete(array $route, string $class, string $method)
    {
        if (! self::postRequestVerify()) {
            return;
        }

        if (! class_exists($class)) {
            throw new Exception("A classe utilizada não existe: {$class}");
        }

        if (! method_exists($class, $method)) {
            throw new Exception("O metodo utilizado não existe: {$method}");
        }

        return self::redirectPost($route, $class, $method);
    }

    /**
     * Verifica se a requisição tipo GET está vazia.
     * @return bool
     */
    private static function getRequestVerify(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    /**
     * Verifica se a requisição tipo POST está vazia.
     * @return bool
     */
    private static function postRequestVerify(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    private static function redirectGet(array $route, string $class, string $method)
    {
        if (! in_array(self::url(), $route, true)) {
            http_response_code(404);
            return;
        }
        
        http_response_code(200);
        $action = new $class;
        $action->{$method}();
    }

    private static function redirectPost(array $route, string $class, string $method)
    {
        if (! in_array(self::url(), $route, true)) {
            http_response_code(404);
            return;
        }
        
        http_response_code(200);
        $action = new $class;
        $action->{$method}();
    }
}
