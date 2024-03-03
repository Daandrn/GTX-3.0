<?php

require_once __DIR__ . "/../configuracao/connection.php";

use function gtx2\configuracao\connection;

/**
 * Carregas as plataformas de strem disponiveis
 * @return array|mixed Retorna lista de plataformas
 */
function carregaPlataformas(): array|bool|string
{
    try {
        $consulta = connection()->query("SELECT * FROM plataformastream ORDER BY id");
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

        return $resultado;
    } catch (PDOException $error) {
        return "Erro ao carregar plataforma: " . $error->getMessage();
    }
}