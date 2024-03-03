<?php

use function gtx2\configuracao\connection;

require_once __DIR__ . "/../configuracao/connection.php";

/**
 * Verica qual versao do sistema está sendo usada
 * @return string Retorna o id da versao
 */
function verificaVersao(): string
{
    try {
        $consulta = connection()->prepare("SELECT id FROM versao WHERE selected = 1");
        $consulta->execute();

        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        return (string) $resultado['id'];
    } catch (PDOException $erro) {
        return "Erro ao verificar versao de sistema: " . $erro->getMessage();
    }
}