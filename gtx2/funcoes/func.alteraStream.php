<?php 

require_once 'dbConnection.php';
$conexao = getDbConnection();
function alteraStream($id, $nickStream, $linkStream, $plataforma) {
    
    try {
        $conexao = getDbConnection();
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

        return ["status" => true, "message" => "Alteração realizada com sucesso!"];

    } catch (PDOexception $erro) {
        return ["status" => false, "message" => "Erro ao alterar o stream."];
    }
    
}

function excluiStream($id) {

    try {
        $conexao = getDbConnection();
        $consulta = $conexao->prepare("UPDATE canalstream SET 
                                                            nickstream = null,
                                                            link_canal = null, 
                                                            plataforma = null
                                                            WHERE id = :id");
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return ["status" => true, "message" => "Exclusão realizada com sucesso!"];

    } catch (PDOException $erro) {
        return ["status" => false, "message" => "Erro ao excluir o stream."];
    }
}

function formatLink($string) {
    $string = str_ireplace(["www.", "https://", "http://"], "", $string);
    return $string;
}

?>