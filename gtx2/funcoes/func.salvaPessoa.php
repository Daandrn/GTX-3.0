<?php

require_once __DIR__ . "/../configuracao/connection.php";

use function gtx2\configuracao\connection;

function salvaPessoa(int $id, string $nome, string $nick, int $plataforma, int $status_solicit) 
{
    try {
        $consulta = connection()->prepare("INSERT INTO pessoa VALUES (:id, :nome, :nick, :plataforma, :status_solicit, 123456)");
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
        $consulta->bindParam(':nome', $nome, PDO::PARAM_STR);
        $consulta->bindParam(':nick', $nick, PDO::PARAM_STR);
        $consulta->bindParam(':plataforma', $plataforma, PDO::PARAM_INT);
        $consulta->bindParam(':status_solicit', $status_solicit, PDO::PARAM_INT);
        $consulta->execute();

        if ($consulta->rowCount() == 1) {
            $retornoSalvaPessoa = true;
        }
        elseif ($consulta->rowCount() != 1) {
            $retornoSalvaPessoa = false;
        }

        $consulta2 = connection()->prepare("INSERT INTO canalstream VALUES (:id, null, null, null)");
        $consulta2->bindParam(':id', $id, PDO::PARAM_INT);
        $consulta2->execute();
    
    } catch (PDOException $erro) {
        echo "Erro no banco de dados: " . $erro->getMessage();
    }
    
    return $retornoSalvaPessoa;
}