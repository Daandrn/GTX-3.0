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

    function alteraSenha($idPessoa) {

        try {

            require __DIR__ . "/../configuracao/conexao.php";

            $consulta = $conexao->prepare("UPDATE pessoa 
                                            SET senha = (SELECT novasenha 
                                                            FROM recuperasenha 
                                                            WHERE id = :id AND solicit_senha = 1 
                                                            ORDER BY data_solicit DESC LIMIT 1)
                                            WHERE id = :id");
            $consulta->bindParam(':id', $idPessoa, PDO::PARAM_INT);
            $consulta->execute();

        } catch (PDOException $erro) {
            echo "Erro ao alterar senha: " . $erro->getMessage();
        }

        try {

            $consulta2 = $conexao->prepare("UPDATE recuperasenha
                                                SET solicit_senha = 0
                                                WHERE id = (SELECT id FROM recuperasenha 
                                                                WHERE id = :id AND solicit_senha = 1 
                                                                ORDER BY data_solicit LIMIT 1)");
            $consulta2->bindParam(':id', $idPessoa, PDO::PARAM_INT);
            $consulta2->execute();

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

}

?>