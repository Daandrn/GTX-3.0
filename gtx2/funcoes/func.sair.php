<?php 

/*
encerra a sessão e redireciona o usuário para o inicio
*/
function sair() 
{
    session_start();
    session_regenerate_id(true);
    session_destroy();
    header("location: /gtx2/control/control.inicio.php");

    return;
}