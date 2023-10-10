<?php

require __DIR__ . "/../funcoes/func.verificasessao.php";

verificaSessao();

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $formularios = $_POST['formLogado'];
    
    switch ($formularios) {
        case '':
            # code...
            break;
        
        case 'form_sair':
            require __DIR__ . "/../funcoes/func.sair.php";
            sair();
            break;
    }
}

require __DIR__ . "/../view/view.arealogada.php";

?>