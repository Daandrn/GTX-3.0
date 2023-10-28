<?php 

function carregaPlataformas() {

    require __DIR__ . "/../configuracao/conexao.php";
    
    try {
        $consulta = $conexao->query("SELECT * FROM plataformastream ORDER BY id");
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

        $plataformas = $resultado;

        return $plataformas;
    } catch (PDOException $e) {
        echo "Erro no banco de dados: " . $e->getMessage();
    }
}

?>