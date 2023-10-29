<?php

require __DIR__ . "/../classe/class.pessoa.php";
require __DIR__ . "/../funcoes/func.verificaSessao.php";
require __DIR__ . "/../funcoes/func.dadosPerfil.php";
require __DIR__ . "/../funcoes/func.dadoStream.php";
require __DIR__ . "/../funcoes/func.plataformaStream.php";
require __DIR__ . "/../funcoes/func.versao.php";
require __DIR__ . "/../funcoes/func.salvaVersao.php";
require __DIR__ . "/../funcoes/func.alteraStream.php";
require __DIR__ . "/../model/model.areaLogada.php";

verificaSessao();

$boasvindas = $_SESSION['nome'];

$idSessao = $_SESSION['id_sessao'];
$nickPerfil = carregaPerfil($idSessao);
$dadoStream = carregaStream($idSessao);

$plataformasStream = carregaPlataformas();

if (!empty($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    
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
            $idExcluiStream = $_SESSION['id_sessao'];

            $responseStream = excluiStream($idExcluiStream);
            header("location: /gtx2/control/control.areaLogada.php");

            break;

        case 'perfilNick':
            $idSessao = $_SESSION['id_sessao'];
            $novoOrigin = $_POST['origin'];

            $responseAlteraNick = "Nick/origin não pode ser vazio!";

            if (!empty($novoOrigin)) {
                
                $pessoa = new pessoa;
                $pessoa->alteraNick($idSessao, $novoOrigin);
                $responseAlteraNick = "Nick/origin alterado com sucesso!";
                header("location: /gtx2/control/control.areaLogada.php");

            }

            break;
            
        case 'perfilSenha':
            $idSessao = $_SESSION['id_sessao'];
            $novaSenha = $_POST['novaSenha'];

            $responseAlteraSenha = "Falha. Use senha uma numérica de 10 digitos!";

            if (!empty($novaSenha) && (strlen($novaSenha) == 10)) {
                
                $pessoa = new pessoa;
                $pessoa->alteraSenha($idSessao, $novaSenha);
                $responseAlteraSenha = "Senha alterada com sucesso!";

            }

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
