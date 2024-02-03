<?php

use function gtx2\configuracao\connection;

require_once __DIR__ . "/../configuracao/connection.php";

/**
 * Verifica qual o maior id das pessoas
 * @return string Retorna o maior id
 */
function maiorID(): string
{
    try {
        $consulta = connection()->prepare("SELECT max(id) AS maior_id FROM pessoa");
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    
        return (string) $resultado['maior_id'];
    } catch (PDOException $erro) {
        return "Erro ao verificar maior id: " . $erro->getMessage();
    }
}