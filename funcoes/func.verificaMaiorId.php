<?php 

function maiorID() {
    
    require __DIR__ . "/../configuracao/conexao.php";
    
    try {
        $consulta = $conexao->prepare("SELECT max(id) AS maior_id FROM pessoa");
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    
        $retornoMaiorId = $resultado['maior_id'];
    
    } catch (PDOException $erro) {
        echo "Erro no banco de dados: " . $erro->getMessage();
    }

    return $retornoMaiorId;
}

?>