<?php 

function carregaPerfil($id)
{
    require __DIR__ . "/../configuracao/conexao.php";
    
    try {
    
        $consulta = $conexao->prepare("SELECT * FROM pessoa WHERE id = :id");
        $consulta->bindParam(':id', $id);
        $consulta->execute();

        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        $origin = $resultado['nick'];
        return $origin;

    } catch (PDOException $erro) {
        echo "Erro no banco de dados: " . $erro->getMessage();
    }
}

?>