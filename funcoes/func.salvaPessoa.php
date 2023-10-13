<?php 
function salvaPessoa($id, $nome, $nick, $plataforma, $status_solicit) {
    try {
        require __DIR__ . "/../configuracao/conexao.php";

        $cosulta = $conexao->prepare("INSERT INTO pessoa VALUES (:id, ':nome', ':nick', :plataforma, ':status_solicit', '123456')");
        $consulta->bindParam(':id', $id);
        $consulta->bindParam(':nome', $nome);
        $consulta->bindParam(':nick', $nick);
        $consulta->bindParam(':plataforma', $plataforma);
        $consulta->bindParam(':status_solicit', $status_solicit);
        $consulta->execute();

        if ($consulta->rowCount() == 1) {
            $retornoSalvaPessoa = true;
        }
        elseif ($consulta->rowCount() != 1) {
            $retornoSalvaPessoa = false;
        }

        $consulta2 = $conexao->prepare("INSERT INTO canalstream VALUES (:id, null, null, null)");
        $consulta2->bindParam(':id', $id);
        $consulta2->execute();
    
    } catch (PDOException $erro) {
        echo "Erro no banco de dados: " . $erro->getMessage();
    }
    
    return $retornoSalvaPessoa;
}

?>