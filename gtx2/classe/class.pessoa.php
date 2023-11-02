<?php 

class pessoa {
    
    var $idPessoa;
    var $nomePessoa;
    var $nickPessoa;
    var $plataformaPessoa;
    var $statusPessoa;
    
    function incluiPessoa($nomePessoa, $nickPessoa, $plataformaPessoa) {

        require __DIR__ . "/../funcoes/func.verificaPessoa.php";
        require __DIR__ . "/../funcoes/func.verificaMaiorId.php";
        require __DIR__ . "/../funcoes/func.salvaPessoa.php";

        if (!verificaPessoa($nickPessoa)) {
            $this->idPessoa = maiorID() + 1;
            $this->nomePessoa = $nomePessoa;
            $this->nickPessoa = $nickPessoa;
            $this->plataformaPessoa = $plataformaPessoa;
            $this->statusPessoa = 0;
            
            salvaPessoa($this->idPessoa, $this->nomePessoa, $this->nickPessoa, $this->plataformaPessoa, $this->statusPessoa);

            $retornoPessoa = "Solicitação realizada com sucesso! Aguarde a aprovação de um dos administradores.";

        } elseif (verificaPessoa($nickPessoa)) {
            $retornoPessoa = "Erro: O nick \"$nickPessoa\" já existe! tente novamente ou tente o recuperar senha.";
        }

        return $retornoPessoa;
    }

    function alteraStatus($idPessoa, $statusPessoa) {
         try {

            require __DIR__ . "/../configuracao/conexao.php";

            $consulta = $conexao->prepare("UPDATE pessoa SET status_solicit = :statusSolicit WHERE id = :id");
            $consulta->bindParam(':id', $idPessoa, PDO::PARAM_INT);
            $consulta->bindParam(':statusSolicit', $statusPessoa, PDO::PARAM_INT);

            $consulta->execute();
            
         } catch (PDOException $erro) {
            echo "Erro no banco de dados: " . $erro->getMessage();
         }
    }

    function alteraNick($idPessoa, $nickPessoa) {

        try {
            
            require __DIR__ . "/../configuracao/conexao.php";

            $consulta = $conexao->prepare("UPDATE pessoa SET nick = :nick WHERE id = :id");
            $consulta->bindParam(':nick', $nickPessoa, PDO::PARAM_STR);
            $consulta->bindParam(':id', $idPessoa, PDO::PARAM_INT);
            $consulta->execute();

            $_SESSION['nick'] = $nickPessoa;

        } catch (PDOException $erro) {
            echo "Erro no banco de dados: " . $erro->getMessage();
        }

        return;

    }

    function alteraSenha($idPessoa, $idUnico) {

        try {

            require __DIR__ . "/../configuracao/conexao.php";

            $consulta = $conexao->prepare("UPDATE pessoa 
                                            SET senha = (SELECT novasenha 
                                                            FROM recuperasenha 
                                                            WHERE id_unico = :id_unico)
                                            WHERE id = :id");
            $consulta->bindParam(':id', $idPessoa, PDO::PARAM_INT);
            $consulta->bindParam(':id_unico', $idUnico, PDO::PARAM_INT);
            $consulta->execute();

        } catch (PDOException $erro) {
            echo "Erro ao alterar senha: " . $erro->getMessage();
        }

        try {

            $consulta2 = $conexao->prepare("UPDATE recuperasenha
                                                SET solicit_senha = 0
                                                WHERE id_unico = :id_unico AND solicit_senha = 1");
            $consulta2->bindParam(':id_unico', $idUnico, PDO::PARAM_INT);
            $consulta2->execute();

        } catch (PDOException $erro) {
            echo "Erro ao alterar status da solicitação de senha: " . $erro->getMessage();
        }

        return;

    }

    function reprovaNovaSenha($idUnico) {

        require __DIR__ . "/../configuracao/conexao.php";

        try {

            $consulta = $conexao->prepare("UPDATE recuperasenha
                                                SET solicit_senha = 2
                                                WHERE id_unico = :id_unico");
            $consulta->bindParam(':id_unico', $idUnico, PDO::PARAM_INT);
            $consulta->execute();

        } catch (PDOException $erro) {
            echo "Erro ao alterar status da solicitação de senha: " . $erro->getMessage();
        }

        return;

    }

    function excluiPessoa($idPessoa) {

        try {
            
            require __DIR__ . "/../configuracao/conexao.php";

            $consulta1 = $conexao->prepare("DELETE FROM canalstream WHERE id = :id");
            $consulta1->bindParam(':id', $idPessoa, PDO::PARAM_INT);
            $consulta1->execute();

            $consulta2 = $conexao->prepare("DELETE FROM pessoa WHERE id = :id");
            $consulta2->bindParam(':id', $idPessoa, PDO::PARAM_INT);
            $consulta2->execute();

        } catch (PDOException $erro) {
            echo "Erro no banco de dados: " . $erro->getMessage();
        }

        return;
    }

    function recuperaSenha($nickPessoa, $novaSenha) {
        
        try {

            require __DIR__ . "/../configuracao/conexao.php";

            $consulta1 = $conexao->query("SELECT max(id_unico) AS id_unico FROM recuperasenha");
            $resultado = $consulta1->fetch(PDO::FETCH_ASSOC);
            $maxIdUnico = $resultado['id_unico'] + 1;

            $dataSolicit = date('d-m-Y');

            $consulta2 = $conexao->prepare("INSERT INTO recuperasenha VALUES ((SELECT id FROM pessoa WHERE nick = :nick), :nick, :novaSenha, 1, :dataSolicit, :id_unico)");
            $consulta2->bindParam(':nick', $nickPessoa, PDO::PARAM_STR);
            $consulta2->bindParam(':novaSenha', $novaSenha, PDO::PARAM_STR);
            $consulta2->bindParam(':dataSolicit', $dataSolicit, PDO::PARAM_STR);
            $consulta2->bindParam('id_unico', $maxIdUnico, PDO::PARAM_INT);
            $consulta2->execute();

            
        } catch (PDOexception $erro) {
            echo "Erro ao solicitar nova senha: " . $erro->getMessage();
        }
        
        return;

    }

}

?>