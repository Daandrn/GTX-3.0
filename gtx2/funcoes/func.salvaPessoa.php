<?php

use function gtx2\configuracao\connection;

require_once __DIR__ . "/../configuracao/connection.php";

/**
 * Insere pessoa no banco
 * @param int $id id da pessoa 
 * @param string $nome Nome da pessoa 
 * @param string $nick Nick da pessoa 
 * @param int $plataforma Plataforma de jogo da pessoa 
 * @param int $status_solicit Status da pessoa 
 * @return bool|string
 */
function salvaPessoa(int $id, string $nome, string $nick, int $plataforma, int $status_solicit): bool|string
{
    try {
        $consulta = connection()->prepare("INSERT INTO pessoa VALUES (:id, :nome, :nick, :plataforma, :status_solicit, 123456)");
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
        $consulta->bindParam(':nome', $nome, PDO::PARAM_STR);
        $consulta->bindParam(':nick', $nick, PDO::PARAM_STR);
        $consulta->bindParam(':plataforma', $plataforma, PDO::PARAM_INT);
        $consulta->bindParam(':status_solicit', $status_solicit, PDO::PARAM_INT);
        
        $consulta2 = connection()->prepare("INSERT INTO canalstream VALUES (:id, null, null, null)");
        $consulta2->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $consulta->execute() && $consulta2->execute(); 
    } catch (PDOException $erro) {
        return "Erro ao salvar pessoa: " . $erro->getMessage();
    }
}