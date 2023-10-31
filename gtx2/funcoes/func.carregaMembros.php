<?php 

try {

    function carregaMembros() {
        
        require __DIR__ . "/../configuracao/conexao.php";
        $consulta = $conexao->query("SELECT pessoa.id AS id, pessoa.nome AS nome, pessoa.nick AS nick, plataformagame.descricao AS plataforma, statusmembro.descricao AS status_membro 
                                        FROM pessoa 
                                        INNER JOIN plataformagame ON pessoa.plataforma = plataformagame.id
                                        INNER JOIN statusmembro ON pessoa.status_solicit = statusmembro.status_solicit
                                        WHERE pessoa.status_solicit IN (1,4) 
                                        ORDER BY pessoa.status_solicit DESC");
        $consulta->execute();
        
        $resultado = $consulta->fetchall(PDO::FETCH_ASSOC);
        
        return $resultado;
        
    }
    
    function carregaRecrut() {
        
        require __DIR__ . "/../configuracao/conexao.php";
        $consulta = $conexao->query("SELECT pessoa.id AS id, pessoa.nome AS nome, pessoa.nick AS nick, plataformagame.descricao AS plataforma, statusmembro.descricao AS status_membro 
                                        FROM pessoa 
                                        INNER JOIN plataformagame ON pessoa.plataforma = plataformagame.id
                                        INNER JOIN statusmembro ON pessoa.status_solicit = statusmembro.status_solicit
                                        WHERE pessoa.status_solicit = 0 
                                        ORDER BY pessoa.id ASC");
        $consulta->execute();
    
        $resultado = $consulta->fetchall(PDO::FETCH_ASSOC);
    
        return $resultado;
    
    }
    
    function carregaRejeitados() {
        
        require __DIR__ . "/../configuracao/conexao.php";
        $consulta = $conexao->query("SELECT pessoa.id AS id, pessoa.nome AS nome, pessoa.nick AS nick, plataformagame.descricao AS plataforma, statusmembro.descricao AS status_membro
                                        FROM pessoa
                                        INNER JOIN plataformagame ON pessoa.plataforma = plataformagame.id
                                        INNER JOIN statusmembro ON pessoa.status_solicit = statusmembro.status_solicit 
                                        WHERE pessoa.status_solicit IN (2,3) 
                                        ORDER BY pessoa.status_solicit ASC");
        $consulta->execute();
    
        $resultado = $consulta->fetchall(PDO::FETCH_ASSOC);
    
        return $resultado;
    
    }
    
    function carregaNovaSenha() {
        
        require __DIR__ . "/../configuracao/conexao.php";
        $consulta = $conexao->query("SELECT id, nick, solicit_senha AS statusSenha FROM recuperasenha WHERE solicit_senha = 1 ORDER BY data_solicit ASC");
        $consulta->execute();
    
        $resultado = $consulta->fetchall(PDO::FETCH_ASSOC);
    
        return $resultado;
    
    }
    
} catch (PDOException $erro) {
    echo "Erro no banco de dados: " . $erro->getMessage();
}

?>