<?php declare(strict_types=1);

use classe\Pessoa;

require __DIR__ . "/../classe/class.pessoa.php";
require __DIR__ . "/../funcoes/func.verificaPessoa.php";
require __DIR__ . "/../funcoes/func.verificaSolicit.php";

if (
    $_SERVER['REQUEST_METHOD'] == 'POST'
    && isset($_POST['recuperaSenhaFrame'])
    && $_POST['recuperaSenhaFrame'] == 'recuperarSenha'
) {
    $nickNovaSenha = (string) $_POST['origin'];
    $novaSenha     = (int) $_POST['newSenha'];

    // if (verificaPessoa($nickNovaSenha)) {
    //     if (!verificaSolicit($nickNovaSenha)) {
    //         if (
    //             !empty($novaSenha) 
    //             && (strlen($novaSenha) == 10)
    //         ) {
    //             $pessoa = new Pessoa;
    //             $pessoa->recuperaSenha($nickNovaSenha, $novaSenha);
    //             $responseRecuperaSenha = "Solicitação realizada com sucesso. Aguarde aprovação de um Adm!";
    //         } else {
    //             $responseRecuperaSenha = "Falha. Use senha uma numérica de 10 digitos!";
    //         }
    //     } else {
    //         $responseExisteSolicit = "Já existe uma solicitação pendente para este nick/origin. Aguarde ou procure um Adm.";
    //     }
    // } else {
    //     $responseExistePessoa = "Não existe cadastro com este nick/origin.";
    // }
}

include __DIR__ . '/../view/view.recuperaSenha.php';
