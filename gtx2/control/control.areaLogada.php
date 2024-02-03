<?php

use classe\Pessoa;

require __DIR__ . "/../classe/class.pessoa.php";
require __DIR__ . "/../funcoes/func.verificaSessao.php";
require __DIR__ . "/../funcoes/func.dadosPerfil.php";
require __DIR__ . "/../funcoes/func.dadoStream.php";
require __DIR__ . "/../funcoes/func.plataformaStream.php";
require __DIR__ . "/../funcoes/func.versao.php";
require __DIR__ . "/../funcoes/func.salvaVersao.php";
require __DIR__ . "/../funcoes/func.alteraStream.php";
require __DIR__ . "/../funcoes/func.carregaMembros.php";
require __DIR__ . "/../model/model.areaLogada.php";

verificaSessao();

$boasvindas = (string) $_SESSION['nome'];
$idSessao = (int) $_SESSION['id_sessao'];

$nickPerfil = carregaPerfil($idSessao);
$dadoStream = carregaStream($idSessao);
$plataformasStream = carregaPlataformas();
$listaMembros = carregaMembros();
$listaRecrut = carregaRecrut();
$listaRejeitados = carregaRejeitados();
$listaNovaSenha = carregaNovaSenha();

if (
    !empty($_SERVER['REQUEST_METHOD']) && 
    $_SERVER['REQUEST_METHOD'] == 'POST' && 
    isset($_POST['formLogado'])
    ) {
    $formPerfil = (string) $_POST['formLogado'];
    
    switch ($formPerfil) {
        case 'canalStream':
            $idStream = (int) $_SESSION['id_sessao'];
            $nickStream = (string) $_POST['nickStream'];
            $linkStream = (string) $_POST['linkStream'];
            $plataforma = (int) $_POST['plataforma'];
            
            $responseStream = "Todos os campos devem ser preenchidos!";
            
            if (
                isset($idStream) && 
                !empty($nickStream) && 
                !empty($linkStream) && 
                !empty($plataforma)
                ) {
                $linkStream = formatLink($linkStream);
                $responseAlteraStream = alteraStream($idStream, $nickStream, $linkStream, $plataforma);
                header("location: /gtx2/control/control.areaLogada.php");
            }
            
            break;            
        case 'excluiCanalStream':
            $idExcluiStream = (int) $_SESSION['id_sessao'];

            $responseStream = excluiStream($idExcluiStream);
            header("location: /gtx2/control/control.areaLogada.php");

            break;
        case 'perfilNick':
            $idSessao = (int) $_SESSION['id_sessao'];
            $novoOrigin = (string) $_POST['origin'];

            $responseAlteraNick = "Nick/origin não pode ser vazio!";

            if (!empty($novoOrigin)) {
                
                $pessoa = new Pessoa;
                $pessoa->alteraNick($idSessao, $novoOrigin);
                $responseAlteraNick = "Nick/origin alterado com sucesso!";
                header("location: /gtx2/control/control.areaLogada.php");
            }

            break;
        case 'perfilSenha':
            $idSessao = (int) $_SESSION['id_sessao'];
            $novaSenha = (int) $_POST['novaSenha'];

            $responseAlteraSenha = "Falha. Use senha uma numérica de 10 digitos!";

            if (!empty($novaSenha) && (strlen($novaSenha) == 10)) {
                $pessoa = new Pessoa;
                $pessoa->atualizaSenha($idSessao, $novaSenha);
                $responseAlteraSenha = "Senha alterada com sucesso!";
            }

            break;
        case 'salvaVersao':
            $versao = (int) $_POST['versao'];

            if ($versao != verificaVersao()){
                alteraVersao($versao);
                header("location: /index.php");
            }

            break;
        case 'form_sair':
            require __DIR__ . "/../funcoes/func.sair.php";
            sair();

            break;
    }
}

if (
    !empty($_SERVER['REQUEST_METHOD']) && 
    $_SERVER['REQUEST_METHOD'] == 'POST' && 
    isset($_POST['acaoMembrosAdm'])
    ) {
    $formMembrosAdm = (array) $_POST['acaoMembrosAdm'];

    switch ($formMembrosAdm[1]) {
        case 'Salvar' :
            $pessoa = new Pessoa;
            $pessoa->alteraStatus($formMembrosAdm[2], $formMembrosAdm[0]);
            header("location: /gtx2/control/control.areaLogada.php");

            break;
        case 'Excluir' :
            $pessoa = new Pessoa;
            $pessoa->excluiPessoa($formMembrosAdm[2]);
            header("location: /gtx2/control/control.arealogada.php");

            break;
        }
}

if (
    !empty($_SERVER['REQUEST_METHOD']) && 
    $_SERVER['REQUEST_METHOD'] == 'POST' && 
    isset($_POST['acaoAlteraSenha'])
    ) {
    $acaoAlteraSenha = (array) $_POST['acaoAlteraSenha'];

    switch ($acaoAlteraSenha[0]) {

        case 'Aprovar' :
            $pessoa = new Pessoa;
            $pessoa->alteraSenha($acaoAlteraSenha[1], $acaoAlteraSenha[2]);
            header("location: /gtx2/control/control.arealogada.php");
        
            break;
        case 'Reprovar' :
            $pessoa = new Pessoa;
            $pessoa->reprovaNovaSenha($acaoAlteraSenha[2]);
            header("location: /gtx2/control/control.arealogada.php");
        
            break;
    }
}

require __DIR__ . "/../view/view.areaLogada.php";