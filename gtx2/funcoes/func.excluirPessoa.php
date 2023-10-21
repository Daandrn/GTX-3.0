<?php 

function excluirPessoa($idExcluir) {

    require __DIR__ . "/../configuracao/conexao.php";
    
    try {

        $consulta = $conexao->prepare("DELETE FROM pessoa WHERE id = :id");
        $consulta->bindParam(':id', $idExcluir);
        $consulta->execute();
    
        if ($consulta->rowCount() > 0) {
            $resposta = true;
        } else {
            $resposta = false;
        }

    } catch (PDOException $erro) {
        echo "Erro no banco de dados: ". $erro->getMessage();
    }

    return $resposta;

} 

?>