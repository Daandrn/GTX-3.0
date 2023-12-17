<?php 

require_once __DIR__ . "/../configuracao/connection.php";

use function gtx2\configuracao\connection;

/* 
Verifica se o nick informado por argumento está presente no banco de dados e retorna true ou false.
*/
function verificaPessoa(string $nickName): bool|string
{
    try {
        $consulta = connection()->prepare("SELECT * FROM pessoa WHERE nick = :nick");
        $consulta->bindParam(':nick', $nickName, PDO::PARAM_STR);
        $consulta->execute();

        if ($consulta->rowCount() > 0) {
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            if ($resultado['nick'] == $nickName) {
                $resposta = true;
            } else {
                $resposta = false;
            }
        } else {
            $resposta = false;
        }
        
        return $resposta;
    } catch (PDOException $erro) {
        return "Erro ao verificar se nick já existe: " . $erro->getMessage();
    }
}