<?php 

require __DIR__."/../configuracao/conexao.php";

try {
    $sql = $conexao->query("SELECT * FROM plataformagame");
    $plataforma = $sql->fetch(PDO::FETCH_ASSOC);
} catch(PDOexception $erro){
    echo "Erro: ". $erro->getMessage();
}

?>