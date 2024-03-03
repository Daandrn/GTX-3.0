<?php

use function gtx2\configuracao\connection;

require_once __DIR__ . "/../configuracao/connection.php";

/**
 * Altera a versao do sistema
 * @return bool|string
 */
function alteraVersao(int $id): bool|string
{
    try {
        $consulta = connection()->prepare("UPDATE versao 
                                            SET selected = CASE 
                                                                WHEN id = :id THEN 1 
                                                                ELSE NULL 
                                                            END");
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
        return $consulta->execute();
    } catch (PDOException $erro) {
        return "Erro ao alterar versão: " . $erro->getMessage();
    }
}