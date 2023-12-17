<?php

require_once __DIR__ . "/../configuracao/connection.php";

use function gtx2\configuracao\connection;

try {
    //consulta as versoes do BD para montar o select na tela
    $sql = connection()->query("SELECT * FROM versao ORDER BY id");

} catch (PDOexception $erro) {
    return "Erro no banco de dados: " . $erro->getMessage();
}