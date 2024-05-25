<?php declare(strict_types=1);

namespace App\Controllers;

use App\Services\MembrosService;
use Vendor\Helpers\Redirect;
use Vendor\RenderView\View;

require_once __DIR__ . '/../../Vendor/autoload.php';

class InicioController
{
    protected MembrosService $membrosService;

    public function __construct()
    {
        $this->membrosService = new MembrosService;
    }

    public function index()
    {
        return View::view('inicio');
    }

    public function inicioLogin()
    {
        if (
            isset($_SERVER['REQUEST_METHOD'])
            && $_SERVER['REQUEST_METHOD'] === 'POST'
            && $_POST['formInicio'] === 'form_login'
        ) {
            $usuarioLogin = $_POST['nick_login'];
            $senhaLogin   = $_POST['senha_login'];

            if (
                strlen($usuarioLogin) === 0
                || strlen($senhaLogin) === 0
            ) {
                return View::view('inicio', ['message' => "Usuário e senha são obrigatórios!"]);
            }

            if (
                strlen($usuarioLogin) < 3
                || strlen($senhaLogin) !== 10
            ) {
                return View::view('inicio', ['message' => "Usuário e/ou senha inválido(os)!"]);
            }

            $loginMembro = new LoginController;
            $response = $loginMembro->login($usuarioLogin, $senhaLogin);

            if (
                isset($response['status_login'])
                && $response['status_login']
            ) {
                return Redirect::to("arealogada");
            }

            return View::view('inicio', ['message' => $response['message']]);
        }

        return View::view('inicio', ['message' => "Erro na requisição!"]);
    }

    public function inicioRecruit()
    {
        if (
            isset($_SERVER['REQUEST_METHOD'])
            && $_SERVER['REQUEST_METHOD'] === 'POST'
            && $_POST['formInicio'] === 'form_recrut'
        ) {
            $response = $this->membrosService->newMember((object) $_POST);

            return View::view('inicio', $response);
        }
    }
}
