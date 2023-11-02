<?php 

    // dados para conexão ao banco de dados 
    //$host = 'localhost';
    $dbname = 'GTX';
    //$usuario = 'postgres';
    //$senha = '123';

    // conexão ao banco de dados para usar com require.
    $conexao = new PDO("pgsql:host=$host;dbname=$dbname", $usuario, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>