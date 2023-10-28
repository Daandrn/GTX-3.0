<?php

require __DIR__ . "/../funcoes/func.verificaSessao.php";
require __DIR__ . "/../model/model.areaLogada.php";

verificaSessao();

$boasvindas = $_SESSION['nome'];

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $formularios = $_POST['formLogado'];
    
    switch ($formularios) {
        case '':
            # code.
            break;

        case 'salvaVersao':
            //echo '<script> confirm("Deseja realmente alterar a versão do aplicativo?") </script>';
            $versao = $_POST['versao'];
            require __DIR__ . "/../funcoes/func.salvaVersao.php";
            alteraVersao($versao);
            header("location: /index.php");
            break;
        
        case 'form_sair':
            //echo '<script> confirm("Sua sessão será finalizada, deseja continuar?") </script>';
            require __DIR__ . "/../funcoes/func.sair.php";
            sair();
            break;
    }
}

require __DIR__ . "/../view/view.areaLogada.php";

?>
