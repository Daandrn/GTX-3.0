<?php

require_once __DIR__ . "/../configuracao/connection.php";

use function gtx2\configuracao\connection;

function alteraVersao(int $id): string
{
    try {
        $consulta = connection()->prepare("UPDATE versao SET selected = CASE 
                                                                        WHEN id = :id THEN 1 
                                                                        ELSE NULL 
                                                                        END");
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
    } catch (PDOException $erro) {
        return "Erro ao alterar versão: " . $erro->getMessage();
    }
}