<?php

namespace App\controllers;

use function Vendor\renderView\view;

require __DIR__.'/../../Vendor/renderView/View.php';

Class InicioController
{
    public function index()
    {
        return view('inicio');
    }

    public function inicioLogin()
    {
        require __DIR__.'/LoginController.php';
        require __DIR__.'/../../Vendor/Helpers/dd.php';
        
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

            $loginMembro = new LoginController;
            $response    = $loginMembro->login($usuarioLogin, $senhaLogin);

            if (empty($response['status_login'])) {
                return header("location: /arealogada");
            }
            
            if (! empty($response['status_login'])) {
                $message = ['message' => $response['message']];

                return view('inicio', $message);
            }
        }

        return view('inicio', ['message' => "Erro na requisição!"]);
    }
}
