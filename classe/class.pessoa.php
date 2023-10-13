<?php 

class pessoa {

    var $idPessoa;
    var $nomePessoa;
    var $nickPessoa;
    var $plataformaPessoa;
    var $statusPessoa;

    function incluiPessoa($nomePessoa, $nickPessoa, $plataformaPessoa) {

        require __DIR__ . "/../funcoes/func.verificaPessoa.php";

        if (!verificaPessoa($nickPessoa)) {
            $this->nomePessoa = $nomePessoa;
            $this->nickPessoa = $nickPessoa;
            $this->plataformaPessoa = $plataformaPessoa;

            $retornoPessoa = "Pessoa incluída com sucesso!";

        } elseif (verificaPessoa($nickPessoa)) {
            $retornoPessoa = "A pessoa com nick $nickPessoa já existe!";
        }

        return $retornoPessoa;
    }

    function excluiPessoa($idPessoa) {

        require __DIR__ . "/../funcoes/func.excluirPessoa.php";
                
        if (excluirPessoa($idPessoa) == true) {
            $retornoExclusao = "Pessoa excluída com sucesso!";
        }
        elseif (excluirPessoa($idPessoa) == false) {
            $retornoExclusao = "Não foi possível excluir pessoa!";
        }

        return $retornoExclusao;
    }

    function alteraPessoa() {
        
    }

}

?>