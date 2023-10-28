<?php 

function alteraVersao($id) {
    
    try {
        require __DIR__ . "/../configuracao/conexao.php";
    
        if ($id == 1) {
            
            $consulta = $conexao->prepare("UPDATE versao SET selected = 1 where id = 1");
            $consulta2 = $conexao->prepare("UPDATE versao SET selected = null where id = 2");

            $consulta->execute();
            $consulta2->execute();

        }

        if ($id == 2) {
            
            $consulta = $conexao->prepare("UPDATE versao SET selected = 1 where id = 2");
            $consulta2 = $conexao->prepare("UPDATE versao SET selected = null where id = 1");

            $consulta->execute();
            $consulta2->execute();

        }
    } catch (PDOException $erro) {
        echo "Erro no banco de dados: " . $erro->getMessage();
    }

    return;

}

?>