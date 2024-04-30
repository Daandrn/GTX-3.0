<?php declare(strict_types=1);

namespace App\controllers;

use App\Services\MembrosService;

use function Vendor\renderView\view;

require_once __DIR__.'/../../Vendor/renderView/View.php';

Class InicioController
{
    protected MembrosService $membrosService;
    
    public function __construct()
    {
        require __DIR__.'/../Services/MembrosService.php';

        $this->membrosService = new MembrosService;
    }
    
    public function index()
    {
        return view('inicio');
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
                return view('inicio', ['message' => "Usuário e senha são obrigatórios!"]);
            }

            if (
                strlen($usuarioLogin) < 3
                || strlen($senhaLogin) !== 10
            ) {
                return view('inicio', ['message' => "Usuário e/ou senha inválido(os)!"]);
            }

            require __DIR__.'/LoginController.php';

            $loginMembro = new LoginController;
            $response = $loginMembro->login($usuarioLogin, $senhaLogin);

            if (
                isset($response['status_login'])
                && $response['status_login']
            ) {
                return header("location: /arealogada");
            }

            return view('inicio', ['message' => $response['message']]);
        }

        return view('inicio', ['message' => "Erro na requisição!"]);
    }

    public function inicioRecruit()
    {
        if (
            isset($_SERVER['REQUEST_METHOD']) 
            && $_SERVER['REQUEST_METHOD'] === 'POST'
            && $_POST['formInicio'] === 'form_recrut'
        ) {
            $response = $this->membrosService->newMember($_POST);

            if (! $response) {
                return view('inicio', ['message' => "Erro ao realizar cadastro!"]);
            }
            
            return view('inicio', ['message' => "Solicitação realizada com sucesso, aguarde que seja aprovada por um dos administradores!"]);
        }
    }
}
