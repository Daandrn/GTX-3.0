<?php 

function alteraVersao($id) {
    
    try {
        require __DIR__ . "/../configuracao/conexao.php";
            
            $consulta = $conexao->prepare("UPDATE versao SET selected = CASE 
                                                                        WHEN id = :id THEN 1 
                                                                        ELSE NULL 
                                                                        END");
            $consulta->bindParam(':id', $id);
            $consulta->execute();

    } catch (PDOException $erro) {
        echo "Erro no banco de dados: " . $erro->getMessage();
    }

    return;

}

?>