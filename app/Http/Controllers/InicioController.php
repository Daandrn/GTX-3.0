<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Requests\Request;
use App\Services\MembroService;

class InicioController
{
    
    public function __construct(
        protected MembroService $membroService,

    ) {
        //
    }

    public function index()
    {
        return view('inicio');
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
                return view('inicio', ['message' => "Usuário inválido!"]);
            }

            if (strlen($senhaLogin) < 8) {
                return view('inicio', ['message' => "Senha inválida!"]);
            }

            $loginMembro = new LoginController;
            $response = $loginMembro->login($usuarioLogin, $senhaLogin);

            if (
                isset($response['status_login'])
                && $response['status_login']
            ) {
                return Redirect::to("arealogada");
            }

            return view('inicio', ['message' => $response['message']]);
        }

        return view('inicio', ['message' => "Erro na requisição!"]);
    }

    public function inicioRecruit()
    {
        $request = Request::new();
        
        if (
            isset($_SERVER['REQUEST_METHOD'])
            && $_SERVER['REQUEST_METHOD'] === 'POST'
            && $request->formInicio === 'form_recrut'
        ) {
            $response = $this->membroService->newMember($request);

            return view('inicio', $response);
        }
    }
}
