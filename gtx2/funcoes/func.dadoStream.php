<?php 

function carregaStream($id)
{
    require __DIR__ . "/../configuracao/conexao.php";
    
    try {
    
        $consulta = $conexao->prepare("SELECT * FROM canalstream WHERE id = :id");
        $consulta->bindParam(':id', $id);
        $consulta->execute();

        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        $perfilStream = [
            "nickStream" => $resultado['nickstream'],
            "linkCanal" => $resultado['link_canal'],
            "plataforma" => $resultado['plataforma']
        ];
        return $perfilStream;

    } catch (PDOException $erro) {
        echo "Erro no banco de dados: " . $erro->getMessage();
    }
}

?>