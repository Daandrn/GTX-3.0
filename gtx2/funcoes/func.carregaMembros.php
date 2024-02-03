<?php 

use function gtx2\configuracao\connection;

require_once __DIR__ . "/../configuracao/connection.php";

try {
    function carregaMembros()
    {
        $consulta = connection()->prepare("SELECT
                                                pessoa.id AS id,
                                                pessoa.nome AS nome,
                                                pessoa.nick AS nick,
                                                plataformagame.descricao AS plataforma,
                                                statusmembro.descricao AS status_membro
                                            FROM pessoa
                                            INNER JOIN plataformagame ON pessoa.plataforma = plataformagame.id
                                            INNER JOIN statusmembro ON pessoa.status_solicit = statusmembro.status_solicit
                                            WHERE pessoa.status_solicit IN (1,4)
                                            ORDER BY pessoa.status_solicit DESC");
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        
        return $resultado;
    }
    
    function carregaRecrut() 
    {
        $consulta = connection()->prepare("SELECT 
                                                pessoa.id AS id,
                                                pessoa.nome AS nome,
                                                pessoa.nick AS nick,
                                                plataformagame.descricao AS plataforma,
                                                statusmembro.descricao AS status_membro
                                            FROM pessoa
                                            INNER JOIN plataformagame ON pessoa.plataforma = plataformagame.id
                                            INNER JOIN statusmembro ON pessoa.status_solicit = statusmembro.status_solicit
                                            WHERE pessoa.status_solicit = 0
                                            ORDER BY pessoa.id ASC");
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    
        return $resultado;
    }
    
    function carregaRejeitados() 
    {    
        $consulta = connection()->prepare("SELECT  
                                                pessoa.id AS id,
                                                pessoa.nome AS nome,
                                                pessoa.nick AS nick,
                                                plataformagame.descricao AS plataforma,
                                                statusmembro.descricao AS status_membro
                                            FROM pessoa
                                            INNER JOIN plataformagame ON pessoa.plataforma = plataformagame.id
                                            INNER JOIN statusmembro ON pessoa.status_solicit = statusmembro.status_solicit
                                            WHERE pessoa.status_solicit IN (2,3)
                                            ORDER BY pessoa.status_solicit ASC");
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    
        return $resultado;
    }
    
    function carregaNovaSenha() 
    {
        $consulta = connection()->prepare("SELECT 
                                                recuperasenha.id,
                                                recuperasenha.id_unico,
                                                pessoa.nome, recuperasenha.nick,
                                                recuperasenha.data_solicit,
                                                statussenha.descricao AS statussenha
                                            FROM recuperasenha
                                            INNER JOIN pessoa ON recuperasenha.id = pessoa.id
                                            INNER JOIN statussenha ON recuperasenha.solicit_senha = statussenha.solicit_senha
                                            WHERE recuperasenha.solicit_senha = 1
                                            ORDER BY data_solicit ASC");
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    
        return $resultado;
    }
    
} catch (PDOException $erro) {
    echo "Erro ao carregar dados: " . $erro->getMessage();
}