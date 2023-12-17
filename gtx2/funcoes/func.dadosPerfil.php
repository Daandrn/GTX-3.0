<?php

require_once __DIR__ . "/../configuracao/connection.php";

use function gtx2\configuracao\connection;

function carregaPerfil(int $id): string
{
    try {
        $consulta = connection()->prepare("SELECT * FROM pessoa WHERE id = :id");
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        $origin = (string) $resultado['nick'];
        
        return $origin;
    } catch (PDOException $erro) {
        return "Erro no banco de dados: " . $erro->getMessage();
    }
}