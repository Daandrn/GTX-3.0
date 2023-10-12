<?php 
/* 
Verifica se o nick informado por argumento está presente no banco de dados e retorna true ou false.
*/
function verificaPessoa($nickName){

    require __DIR__ . "/../configuracao/conexao.php";
    require __DIR__ . "/../control/control.inicio.php";

    $consulta = $conexao->prepare("SELECT * FROM pessoa WHERE nick = :nick");
    $consulta->bindParam(':nick', $nickName);
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
};

?>