<?php 

function verificaSessao() {

    session_start();

    if(!isset($_SESSION['nome'])){

        session_regenerate_id();
        $_SESSION = array();
        session_destroy();
        header("location: /../control/control.inicio.php");

    }

    return;
}

?>