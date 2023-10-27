<?php 


function verificaVersao() {
    try {

        require __DIR__ . "/../configuracao/conexao.php";
        $sql = ("SELECT id FROM versao");
        $consulta = $conexao->prepare($sql);
        $consulta->execute();

        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        return $resultado['id'];

    } catch (PDOException $erro) {
        echo "Erro no banco de dados: " . $erro->getMessage();
    }
}

?>