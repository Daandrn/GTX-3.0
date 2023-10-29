<?php 


function alteraStream($id, $nickStream, $linkStream, $plataforma) {
    
    try {
        
        require __DIR__ . "/../configuracao/conexao.php";
        
        $consulta = $conexao->prepare("UPDATE canalstream SET 
                                        nickstream = :nickStream,
                                        link_canal = :linkCanal, 
                                        plataforma = :plataforma
                                        WHERE id = :id");
        $consulta->bindParam(':nickStream', $nickStream, PDO::PARAM_STR);
        $consulta->bindParam(':linkCanal', $linkStream, PDO::PARAM_STR);
        $consulta->bindParam(':plataforma', $plataforma, PDO::PARAM_INT);
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
        
        $consulta->execute();
        
        $return = "Alteração realizada com sucesso!";
        
        return $return;
        
    } catch (PDOexception $erro) {
        echo "Erro no banco de dados: " . $erro->getMessage();        
    }
    
}

function excluiStream($id) {

    try {
        
        require __DIR__ . "/../configuracao/conexao.php";
        
        $consulta = $conexao->prepare("UPDATE canalstream SET 
                                                            nickstream = null,
                                                            link_canal = null, 
                                                            plataforma = null
                                                            WHERE id = :id");
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        $return = "Exclusão realizada com sucesso!";
        
        return $return;

    } catch (PDOException $erro) {
        echo "Erro no banco de dados: " . $erro->getMessage();        
    }
}

function formatLink(string $string): string {

    $string = ltrim($string, "http://");
    $string = ltrim($string, "HTTP://");
    $string = ltrim($string, "https://");
    $string = ltrim($string, "HTTPS://");
    $string = ltrim($string, "www.");

    return $string;
}

?>