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
            
            salvaPessoa($this->idPessoa, $this->nomePessoa, $this->nickPessoa, $this->plataformaPessoa, $this->statusPessoa);

            $retornoPessoa = "Solicitação realizada com sucesso! Aguarde a aprovação de um dos administradores.";

        } elseif (verificaPessoa($nickPessoa)) {
            $retornoPessoa = "Erro: O nick \"$nickPessoa\" já existe! tente novamente ou tente o recuperar senha.";
        }

        return $retornoPessoa;
    }

    function pendente() {
        $this->statusPessoa = 0;
    }

    function membro() {
        $this->statusPessoa = 1;
    }

    function rejeitado() {
        $this->statusPessoa = 2;
    }

    function expulso() {
        $this->statusPessoa = 3;
    }

    function administrador() {
        $this->statusPessoa = 4;
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

    function alteraSenha($idPessoa, $novaSenha) {

        try {

            require __DIR__ . "/../configuracao/conexao.php";

            $consulta = $conexao->prepare("UPDATE pessoa SET senha = :novaSenha WHERE id = :id");
            $consulta->bindParam(':novaSenha', $novaSenha, PDO::PARAM_STR);
            $consulta->bindParam(':id', $idPessoa, PDO::PARAM_INT);
            $consulta->execute();

        } catch (PDOException $erro) {
            echo "Erro no banco de dados: " . $erro->getMessage();
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