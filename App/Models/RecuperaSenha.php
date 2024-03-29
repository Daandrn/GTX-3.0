<?php declare(strict_types=1);

namespace App\Models;

class RecuperaSenha implements modelInterface
{
    public function __construct(Type $args)
    {
        # code...
    }

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
