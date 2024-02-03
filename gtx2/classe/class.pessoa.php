<?php 

namespace classe;

use PDO;
use PDOException;

use function gtx2\configuracao\connection;

require __DIR__ . "/../configuracao/connection.php";

/**
 * Classe da entidade pessoa
 */
class Pessoa 
{
    public int $idPessoa;
    public string $nomePessoa;
    public string $nickPessoa;
    public int $plataformaPessoa;
    public int $statusPessoa;
    
    /**
     * Inclui pessoa com nome, nick e a plataforma de jogo da pessoa
     */
    public function incluiPessoa(string $nomePessoa, string $nickPessoa, int $plataformaPessoa): string
    {
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

            return "Solicitação realizada com sucesso! Aguarde a aprovação de um dos administradores.";
        } elseif (verificaPessoa($nickPessoa)) {
            return "Erro: O nick \"$nickPessoa\" já existe! tente novamente ou tente o recuperar senha.";
        }
    }

    /**
     * Altera o status da pessoa.
     */
    public function alteraStatus(int $idPessoa, int $statusPessoa): bool|string
    {
        try {
            $consulta = connection()->prepare("UPDATE pessoa SET status_solicit = :statusSolicit WHERE id = :id");
            $consulta->bindParam(':id', $idPessoa, PDO::PARAM_INT);
            $consulta->bindParam(':statusSolicit', $statusPessoa, PDO::PARAM_INT);

            return $consulta->execute();
        } catch (PDOException $erro) {
            return "Erro ao alterar status: " . $erro->getMessage();
        }
    }

    /**
     * Altera o nick name da pessoa.
     */
    public function alteraNick(int $idPessoa, string $nickPessoa): bool|string
    {
        try {
            $consulta = connection()->prepare("UPDATE pessoa SET nick = :nick WHERE id = :id");
            $consulta->bindParam(':nick', $nickPessoa, PDO::PARAM_STR);
            $consulta->bindParam(':id', $idPessoa, PDO::PARAM_INT);
            $_SESSION['nick'] = $nickPessoa;

            return $consulta->execute();
        } catch (PDOException $erro) {
            return "Erro ao alterar nick: " . $erro->getMessage();
        }
    }

    /**
     * Altera senha da pessoa pelo perfil
     */
    public function atualizaSenha(int $id, int $novaSenha): bool|string
    {
        try {
            $consulta = connection()->prepare("UPDATE pessoa SET senha = :novasenha WHERE id = :id");
            $consulta->bindParam(":id", $id, PDO::PARAM_INT);
            $consulta->bindParam(":novasenha", $novaSenha, PDO::PARAM_INT);
             
            return $consulta->execute();
        } catch (PDOException $error) {
            return "Erro ao atualizar senha: " . $error->getMessage();
        }
    }

    /**
     * Altera senha da pessoa pela solicitação de recuperação
     */
    public function alteraSenha(int $idPessoa, int $idUnico): bool|string
    {
        try {
            $consulta = connection()->prepare("UPDATE pessoa 
                                                SET senha = (SELECT novasenha 
                                                             FROM recuperasenha 
                                                             WHERE id_unico = :id_unico)
                                                WHERE id = :id");
            $consulta->bindParam(':id', $idPessoa, PDO::PARAM_INT);
            $consulta->bindParam(':id_unico', $idUnico, PDO::PARAM_INT);
            $consulta->execute();
        } catch (PDOException $erro) {
            return "Erro ao alterar senha: " . $erro->getMessage();
        }

        try {
            $consulta2 = connection()->prepare("UPDATE recuperasenha
                                                SET solicit_senha = 0
                                                WHERE id_unico = :id_unico AND solicit_senha = 1");
            $consulta2->bindParam(':id_unico', $idUnico, PDO::PARAM_INT);

            return $consulta2->execute();
        } catch (PDOException $erro) {
            return "Erro ao alterar status da solicitação de senha: " . $erro->getMessage();
        }
    }

    /**
     * Usado quando é necessário negar uma solicitação de nova senha
     */
    public function reprovaNovaSenha(int $idUnico): bool|string
    {
        try {
            $consulta = connection()->prepare("UPDATE recuperasenha
                                                SET solicit_senha = 2
                                                WHERE id_unico = :id_unico");
            $consulta->bindParam(':id_unico', $idUnico, PDO::PARAM_INT);

            return $consulta->execute();
        } catch (PDOException $erro) {
            return "Erro ao alterar status da solicitação de senha: " . $erro->getMessage();
        }
    }

    /**
     * Usado para excluir uma pessoa 
     */
    public function excluiPessoa(int $idPessoa): bool|string
    {
        try {
            $consulta1 = connection()->prepare("DELETE FROM canalstream WHERE id = :id");
            $consulta1->bindParam(':id', $idPessoa, PDO::PARAM_INT);
            $consulta1->execute();

            $consulta2 = connection()->prepare("DELETE FROM pessoa WHERE id = :id");
            $consulta2->bindParam(':id', $idPessoa, PDO::PARAM_INT);

            return $consulta2->execute();
        } catch (PDOException $erro) {
            return "Erro no banco de dados: " . $erro->getMessage();
        }
    }

    /**
     * Recuperar senha da pessoa
     */
    public function recuperaSenha(string $nickPessoa, int $novaSenha): bool|string
    {
        try {
            $consulta1 = connection()->query("SELECT max(id_unico) AS id_unico FROM recuperasenha");
            $resultado = $consulta1->fetch(PDO::FETCH_ASSOC);
            $maxIdUnico = $resultado['id_unico'] + 1;

            $dataSolicit = date('d-m-Y');

            $consulta2 = connection()->prepare("INSERT INTO recuperasenha VALUES ((SELECT id FROM pessoa WHERE nick = :nick), :nick, :novaSenha, 1, :dataSolicit, :id_unico)");
            $consulta2->bindParam(':nick', $nickPessoa, PDO::PARAM_STR);
            $consulta2->bindParam(':novaSenha', $novaSenha, PDO::PARAM_STR);
            $consulta2->bindParam(':dataSolicit', $dataSolicit, PDO::PARAM_STR);
            $consulta2->bindParam('id_unico', $maxIdUnico, PDO::PARAM_INT);
            
            return $consulta2->execute();
        } catch (PDOexception $erro) {
            return "Erro ao solicitar nova senha: " . $erro->getMessage();
        }
    }
}