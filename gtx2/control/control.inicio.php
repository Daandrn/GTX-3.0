<?php

require __DIR__ . "/../model/model.inicio.php";

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

    $formulario = $_POST['formInicio'];

    switch ($formulario) {
        case 'form_login':

            $usuarioLogin = $_POST['nick_login'];
            $senhaLogin = $_POST['senha_login'];

            require __DIR__ . "/../funcoes/func.login.php";

            $responseLogin = login($usuarioLogin, $senhaLogin);

            break;

        case 'form_recrut':

            $nomeRecrut = $_POST['nome_recrut'];
            $nickRecrut = $_POST['nick_recrut'];
            $plataformaRecrut = $_POST['plataforma_recrut'];

            require_once __DIR__ . "/../classe/class.pessoa.php";

            $recrutado = new pessoa();
            $responseRecrut = $recrutado->incluiPessoa($nomeRecrut, $nickRecrut, $plataformaRecrut);

            break;
    }
}
require __DIR__ . "/../view/view.inicio.php";

?>