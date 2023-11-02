<?php 


function verificaSolicit($nickSolicit) {

    try {

        require __DIR__ . "/../configuracao/conexao.php";

        $consulta = $conexao->prepare("SELECT id_unico FROM recuperasenha WHERE nick = :nick AND solicit_senha = 1");
        $consulta->bindParam(':nick', $nickSolicit, PDO::PARAM_STR);
        $consulta->execute();

        $response = true;

        if ($consulta->rowCount() > 0) {
            $response = false;
        }
        
    } catch (PDOException $erro) {
        echo "Erro ao verificar solicitações: " . $erro->getMessage();
    }

    return $response;
    
}

?>