<?php 

function carregaPerfil($nick)
{
    require __DIR__ . "/../configuracao/conexao.php";
    
    try {
    
        $consulta = $conexao->prepare("SELECT * FROM pessoa WHERE nick = :nick");
        $consulta->bindParam(':nick', $nick);
        $consulta->execute();

        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        $origin = $resultado['nick'];
        return $origin;

    } catch (PDOException $erro) {
        echo "Erro no banco de dados: " . $erro->getMessage();
    }
}

?>