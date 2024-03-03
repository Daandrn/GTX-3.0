<?php 

use function gtx2\configuracao\connection;

require_once __DIR__ . "/../configuracao/connection.php";

/**
 * Verifica se o nick informado por argumento está presente no banco de dados
 * @return bool|string Retorna true ou false
 */

function verificaPessoa(string $nickName): bool|string
{
    try {
        $consulta = connection()->prepare("SELECT * FROM pessoa WHERE nick = :nick");
        $consulta->bindParam(':nick', $nickName, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->rowCount() > 0;
    } catch (PDOException $erro) {
        return "Erro ao verificar se nick já existe: " . $erro->getMessage();
    }
}

