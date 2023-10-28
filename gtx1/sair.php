<?php 
    
    session_start();
    session_regenerate_id(true);
    $_SESSION = array();
    session_destroy(); // Encerra a sessão
    // Redireciona para o index
    header('Location: index.php');
    exit();
