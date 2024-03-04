<?php declare(strict_types=1);

namespace App\Models;

use App\Interfaces\ModelInterface;

class CanalStream implements ModelInterface
{
    # code...
}

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

// cria canal stram da pessoa que esta sendo cadastrada.
$consulta2 = connection()->prepare("INSERT INTO canalstream VALUES (:id, null, null, null)");
$consulta2->bindParam(':id', $id, PDO::PARAM_INT);

// exclui canal stream
$consulta1 = connection()->prepare("DELETE FROM canalstream WHERE id = :id");
$consulta1->bindParam(':id', $idPessoa, PDO::PARAM_INT);
$consulta1->execute();