<?php 
/* 
Verifica se o nick informado por argumento está presente no banco de dados e retorna true ou false.
*/


require_once 'dbConnection.php';
function verificaPessoa($nickName){
    try {
        $conexao = getDbConnection();
        $consulta = $conexao->prepare("SELECT * FROM pessoa WHERE nick = :nick");
        $consulta->bindParam(':nick', $nickName);
        $consulta->execute();
        $resposta = ["exite" => $consulta->rowCount()>0];
        return $resposta;

    } catch (PDOException $erro) {
            error_log("Erro no banco de dados" . $erro->getMessage());
            return ["existe" => false, "erro" => "Erro ao verificar nickName"];
    }
};

?>