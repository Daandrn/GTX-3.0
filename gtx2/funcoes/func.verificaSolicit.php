<?php

use function gtx2\configuracao\connection;

require_once __DIR__ . "/../configuracao/connection.php";

/**
 * Verifica se há solicitação de alteração de senha pendente
 * @return bool|string Retorna true se houver solicitação pendente
 */
function verificaSolicit(string $nickSolicit): bool|string
{
    try {
        $consulta = connection()->prepare("SELECT 
                                            id_unico 
                                        FROM recuperasenha 
                                        WHERE nick = :nick AND solicit_senha = 1");
        $consulta->bindParam(':nick', $nickSolicit, PDO::PARAM_STR);
        $consulta->execute();
        
        return $consulta->rowCount() > 0;
    } catch (PDOException $erro) {
        return "Erro ao verificar solicitações: " . $erro->getMessage();
    }
}