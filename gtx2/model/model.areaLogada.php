<?php 

    require __DIR__ . "/../configuracao/conexao.php";

        try {
            //consulta as versoes do BD para montar o select na tela
            $sql = $conexao->query("SELECT * FROM versao ORDER BY id");

        } catch (PDOexception $erro) {
            echo "Erro no banco de dados: " . $erro->getMessage();
        }

?>