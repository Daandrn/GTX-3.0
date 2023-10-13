<?php 

class pessoa {
    
    var $idPessoa;
    var $nomePessoa;
    var $nickPessoa;
    var $plataformaPessoa;
    var $statusPessoa;
    
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


    /*function alteraPessoa() {
        
    }*/

}

?>