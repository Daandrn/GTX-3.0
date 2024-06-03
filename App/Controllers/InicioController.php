<?php declare(strict_types=1);

namespace App\Controllers;

use App\Requests\Request;
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
        $request = Request::new();
        
        if (
            isset($_SERVER['REQUEST_METHOD'])
            && $_SERVER['REQUEST_METHOD'] === 'POST'
            && $request->formInicio === 'form_login'
        ) {
            $usuarioLogin = $request->nick_login;
            $senhaLogin   = $request->senha_login;

            if (strlen($usuarioLogin) < 3) {
                return View::view('inicio', ['message' => "Usuário inválido!"]);
            }

            if (strlen($senhaLogin) < 8) {
                return View::view('inicio', ['message' => "Senha inválida!"]);
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
        $request = Request::new();
        
        if (
            isset($_SERVER['REQUEST_METHOD'])
            && $_SERVER['REQUEST_METHOD'] === 'POST'
            && $request->formInicio === 'form_recrut'
        ) {
            $response = $this->membrosService->newMember($request);

            return View::view('inicio', $response);
        }
    }
}
