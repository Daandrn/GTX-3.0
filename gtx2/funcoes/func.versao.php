<?php

require_once __DIR__ . "/../configuracao/connection.php";

use function gtx2\configuracao\connection;

function verificaVersao(): string
{
    try {
        $sql = ("SELECT id FROM versao WHERE selected = 1");
        $consulta = connection()->prepare($sql);
        $consulta->execute();

        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        return $resultado['id'];
    } catch (PDOException $erro) {
        return "Erro no banco de dados: " . $erro->getMessage();
    }
}