<?php 
/*
Verifica se a pessoa já tem uma sessao logada ativa e, caso não, limpo o array da sessao e destroi a sessão
 */
function verificaSessao() {

    session_start();

    if(!isset($_SESSION['nick'])){

        session_regenerate_id();
        $_SESSION = array();
        session_destroy();
        header("location: /gtx2/control/control.inicio.php");

    }

    return;
}

?>