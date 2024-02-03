<?php

use function gtx2\configuracao\connection;

require_once __DIR__ . "/../configuracao/connection.php";

/**
 * Busca nick da pessoa
 * @param int $id id da pessoa
 */
function carregaPerfil(int $id): string
{
    try {
        $consulta = connection()->prepare("SELECT * FROM pessoa WHERE id = :id");
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        return (string) $resultado['nick'];
    } catch (PDOException $erro) {
        return "Erro no banco de dados: " . $erro->getMessage();
    }
}