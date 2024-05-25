<?php declare(strict_types=1);

namespace Vendor\Routes;

use Exception;

require_once __DIR__ . '/../autoload.php';

final class Route
{
    private static function url(): string
    {
        $url = explode('/', $_SERVER['REQUEST_URI']);

        return $url[1];
    }

    public static function get(array $route, string $class, string $method)
    {
        if (!self::getRequestVerify()) {
            return;
        }

        if (!in_array(self::url(), $route, true)) {
            return;
        }

        if (!class_exists($class)) {
            throw new Exception("A classe utilizada não existe: {$class}");
        }
        
        if (!method_exists($class, $method)) {
            throw new Exception("O metodo utilizado não existe: {$method}. Da classe: {$class}");
        }

        return self::redirectGet($class, $method);
    }

    public static function post(array $route, string $class, string $method)
    {
        if (!self::postRequestVerify()) {
            return;
        }

        if (!in_array(self::url(), $route, true)) {
            return;
        }

        if (!class_exists($class)) {
            throw new Exception("A classe utilizada não existe: {$class}");
        }

        if (!method_exists($class, $method)) {
            throw new Exception("O metodo utilizado não existe: {$method}. Da classe: {$class}");
        }

        return self::redirectPost($class, $method);
    }

    public static function put(array $route, string $class, string $method)
    {
        if (!self::postRequestVerify()) {
            return;
        }

        if (!in_array(self::url(), $route, true)) {
            return;
        }

        if (!class_exists($class)) {
            throw new Exception("A classe utilizada não existe: {$class}");
        }

        if (!method_exists($class, $method)) {
            throw new Exception("O metodo utilizado não existe: {$method}. Da classe: {$class}");
        }

        return self::redirectPost($class, $method);
    }

    public static function patch(array $route, string $class, string $method)
    {
        if (!self::postRequestVerify()) {
            return;
        }

        if (!in_array(self::url(), $route, true)) {
            return;
        }

        if (!class_exists($class)) {
            throw new Exception("A classe utilizada não existe: {$class}");
        }

        if (!method_exists($class, $method)) {
            throw new Exception("O metodo utilizado não existe: {$method}. Da classe: {$class}");
        }

        return self::redirectPost($class, $method);
    }

    public static function delete(array $route, string $class, string $method)
    {
        if (!self::postRequestVerify()) {
            return;
        }

        if (!in_array(self::url(), $route, true)) {
            return;
        }

        if (!class_exists($class)) {
            throw new Exception("A classe utilizada não existe: {$class}");
        }

        if (!method_exists($class, $method)) {
            throw new Exception("O metodo utilizado não existe: {$method}. Da classe: {$class}");
        }

        return self::redirectPost($class, $method);
    }

    /**
     * Realiza redireciamento para as rotas definidas.
     */
    public static function redirection(string $class, string $method, ?array $errors = null, ?array $data = null)
    {

        if (!class_exists($class)) {
            throw new Exception("A classe utilizada não existe: {$class}");
        }

        if (!method_exists($class, $method)) {
            throw new Exception("O metodo utilizado não existe: {$method}. Da classe: {$class}");
        }

        return self::redirectGetWithData($class, $method, $errors, $data);
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

    private static function redirectGetWithData(string $class, string $method, ?array $errors = null, ?array $data = null)
    {
        http_response_code(200);
        $action = new $class;
        $action->{$method}($errors, $data);
        return;
    }

    private static function redirectGet(string $class, string $method)
    {
        http_response_code(200);
        $action = new $class;
        $action->{$method}();
        return;
    }

    private static function redirectPost(string $class, string $method)
    {
        http_response_code(200);
        $action = new $class;
        $action->{$method}();
        return;
    }
}
