<?php

require __DIR__ . "/../funcoes/func.verificaSessao.php";
require __DIR__ . "/../funcoes/func.dadosPerfil.php";
require __DIR__ . "/../funcoes/func.dadoStream.php";
require __DIR__ . "/../funcoes//func.plataformaStream.php";
require __DIR__ . "/../funcoes/func.versao.php";
require __DIR__ . "/../funcoes/func.salvaVersao.php";
require __DIR__ . "/../funcoes/func.alteraStream.php";
require __DIR__ . "/../model/model.areaLogada.php";

verificaSessao();

$boasvindas = $_SESSION['nome'];

$nickSessao = $_SESSION['nick'];
$nickPerfil = carregaPerfil($nickSessao);

$idSessao = $_SESSION['id_sessao'];
$dadoStream =carregaStream($idSessao);

$plataformasStream = carregaPlataformas();

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $formularios = $_POST['formLogado'];
    
    switch ($formularios) {
        case 'canalStream':
            $idStream = $_SESSION['id_sessao'];
            $nickStream = $_POST['nickStream'];
            $linkStream = $_POST['linkStream'];
            $plataforma = $_POST['plataforma'];
            
            $responseStream = "Todos os campos devem ser preenchidos!";
            
            if (isset($idStream) && !empty($nickStream) && !empty($linkStream) && !empty($plataforma)){
                $linkStream = formatLink($linkStream);
                $responseAlteraStream = alteraStream($idStream, $nickStream, $linkStream, $plataforma);
                header("location: /gtx2/control/control.areaLogada.php");
            }

            break;
            
        case 'excluiCanalStream':
            $idStream = $_SESSION['id_sessao'];

            $responseStream = excluiStream($idStream);
            header("location: /gtx2/control/control.areaLogada.php");

            break;

        case 'perfilNick':
            $novoOrigin = $_POST['origin'];

            //$responseAlteraNick = ;

            break;
            
        case 'perfilSenha':
            $novaSenha = $_POST['novaSenha'];

            //$responseAlteraSenha = ;

            break;
            
        case 'salvaVersao':
            $versao = $_POST['versao'];
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

require __DIR__ . "/../view/view.areaLogada.php";

?>
