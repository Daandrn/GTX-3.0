<?php
require_once __DIR__ . "/../configuracao/connection.php";

use function gtx2\configuracao\connection;

function maiorID(): string
{
    try {
        $consulta = connection()->prepare("SELECT max(id) AS maior_id FROM pessoa");
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    
        $retornoMaiorId = $resultado['maior_id'];
    
        return $retornoMaiorId;
    } catch (PDOException $erro) {
        return "Erro ao verificar maior id: " . $erro->getMessage();
    }
}