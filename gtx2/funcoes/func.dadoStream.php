<?php

use function gtx2\configuracao\connection;

require_once __DIR__ . "/../configuracao/connection.php";

/**
 * Carrega canal de stream da pessoa
 * @param int $id id da pessoa 
 * @return array Dados do canal de stream
 */
function carregaStream(int $id): array|string
{
    try {
        $consulta = connection()->prepare("SELECT * FROM canalstream WHERE id = :id");
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        $perfilStream = [
            "nickStream" => $resultado['nickstream'],
            "linkCanal" => $resultado['link_canal'],
            "plataforma" => $resultado['plataforma']
        ];
        return (array) $perfilStream;
    } catch (PDOException $erro) {
        return "Erro ao carregar canal stream: " . $erro->getMessage();
    }
}