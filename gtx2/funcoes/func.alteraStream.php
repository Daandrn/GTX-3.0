<?php 

use function gtx2\configuracao\connection;

require_once __DIR__ . "/../configuracao/connection.php";

function alteraStream(int $id, string $nickStream, string $linkStream, int $plataforma): string
{
    try {
        $consulta = connection()->prepare("UPDATE canalstream 
                                            SET nickstream = :nickStream,
                                                link_canal = :linkCanal, 
                                                plataforma = :plataforma
                                            WHERE id = :id");
        $consulta->bindParam(':nickStream', $nickStream, PDO::PARAM_STR);
        $consulta->bindParam(':linkCanal', $linkStream, PDO::PARAM_STR);
        $consulta->bindParam(':plataforma', $plataforma, PDO::PARAM_INT);
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
        
        return "Alteração realizada com sucesso!";
    } catch (PDOexception $erro) {
        return "Erro no banco de dados: " . $erro->getMessage();        
    }
}

function excluiStream(int $id): string
{
    try {
        $consulta = connection()->prepare("UPDATE canalstream 
                                            SET nickstream = null,
                                                link_canal = null, 
                                                plataforma = null
                                            WHERE id = :id");
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return "Exclusão realizada com sucesso!";
    } catch (PDOException $erro) {
        return "Erro no banco de dados: " . $erro->getMessage();        
    }
}

function formatLink(string $string) 
{
    return str_ireplace(["www.", "https://", "http://"], "", $string);
}