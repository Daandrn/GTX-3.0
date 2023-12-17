<?php

require_once __DIR__ . "/../configuracao/connection.php";

use function gtx2\configuracao\connection;

function verificaSolicit($nickSolicit): bool|string
{
    try {
        $consulta = connection()->prepare("SELECT id_unico FROM recuperasenha WHERE nick = :nick AND solicit_senha = 1");
        $consulta->bindParam(':nick', $nickSolicit, PDO::PARAM_STR);
        $consulta->execute();

        $response = true;

        if ($consulta->rowCount() > 0) {
            $response = false;
        }
        
        return $response;
    } catch (PDOException $erro) {
        return "Erro ao verificar solicitações: " . $erro->getMessage();
    }
}