<?php

namespace App\controllers;

use function Vendor\renderView\view;
require __DIR__.'/../../Vendor/renderView/View.php';


Class InicioController
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        return view('inicio');
    }
}

/*
if (
    isset($_SERVER['REQUEST_METHOD']) && 
    $_SERVER['REQUEST_METHOD'] == 'POST'
    ) {
    $formulario = (string) $_POST['formInicio'];

    switch ($formulario) {
        case 'form_login':
            $usuarioLogin = (string) $_POST['nick_login'];
            $senhaLogin = (int) $_POST['senha_login'];

            require __DIR__ . "/../funcoes/func.login.php";

            $responseLogin = login($usuarioLogin, $senhaLogin);

            break;
        case 'form_recrut':
            $nomeRecrut = (string) $_POST['nome_recrut'];
            $nickRecrut = (string) $_POST['nick_recrut'];
            $plataformaRecrut = $_POST['plataforma_recrut'];

            require_once __DIR__ . "/../classe/class.pessoa.php";

            $recrutado = new Pessoa();
            // ao salvar a pessoa ainda não esta inserindo o canalstream, verificar
            $responseRecrut = $recrutado->incluiPessoa($nomeRecrut, $nickRecrut, $plataformaRecrut);

            break;
    }
}

require __DIR__ . "/../view/view.inicio.php";*/