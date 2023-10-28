<?php

    // para atualizar situação dos membros
    $acao = $_POST['acao'];
    $idsolicit = $_POST['id'];


    // para excluir solicitações e membros expulsos.
    $excluir = $_POST['excluir'];
    $idexcluir = $_POST['id'];

    // para excluir solicitação de alterar senha.
    $excluisenha = $_POST['excluisenha'];
    $idexcluisenha = $_POST['idexcluisenha'];


    // para aceitar solicitação de alterar senha.
    $aceitasenha = $_POST['aceitasenha'];
    $idaceitasenha = $_POST['idaceitasenha'];
    $datasolic = $_POST['datasolic'];

    // chama o arquivo que Cria a conexão com o PostgreSQL usando PDO
    require_once __DIR__."/conexao.php";

    // para excluir solicitações e membros expulsos.
    if ($excluir == 10) { 

        try{

            // exclui o canal stream devido ter chave estranfeira.
            $sql2 = "DELETE FROM canalstream 
                     WHERE id = '$idexcluir'";
            $consulta2 = $conexao->prepare($sql2);
            $consulta2->execute();
            
         // Prepara a consulta SQL de exclusão
        $sql = "DELETE FROM pessoa 
                WHERE id = '$idexcluir'";
        $consulta = $conexao->prepare($sql);

        // Executa a consulta de atualização
        $consulta->execute();

        if ($consulta->rowCount() > 0) {
            header('location: area-logada.php');
            exit;
        }
        } catch (PDOException $e) {
            // Erro na conexão com o banco de dados
            echo 'Erro na conexão com o banco de dados: ' . $e->getMessage();
        }

    } 
    
 // para excluir solicitação de alterar senha.    
    elseif ($excluisenha == 11) { 
        try{

         // Prepara a consulta SQL de exclusão
        $sql = "DELETE FROM recuperasenha 
                WHERE id = '$idexcluisenha'";
        $consulta = $conexao->prepare($sql);

        // Executa a consulta de atualização
        $consulta->execute();

        if ($consulta->rowCount() > 0) {
            header('location: area-logada.php');
            exit;
        }
        } catch (PDOException $e) {
            // Erro na conexão com o banco de dados
            echo 'Erro na conexão com o banco de dados: ' . $e->getMessage();
        }
    } 
    
 // para aceitar solicitação de alterar senha.    
     elseif ($aceitasenha == 21) { 
        try{

         // Prepara a consulta SQL de exclusão
        $sql = "UPDATE pessoa 
                SET senha = (select novasenha 
                                from recuperasenha 
                                where id = '$idaceitasenha' and data_solicit = '$datasolic') 
                WHERE id = '$idaceitasenha'";
        $consulta = $conexao->prepare($sql);

        // Executa a consulta de atualização
        $consulta->execute();

        $sql = "UPDATE recuperasenha 
                SET solicit_senha = 0  
                WHERE id = '$idaceitasenha' and data_solicit = '$datasolic'";
        $consulta = $conexao->prepare($sql);

        // Executa a consulta de atualização
        $consulta->execute();

        if ($consulta->rowCount() > 0) {
            header('location: area-logada.php');
            exit;
        }
        } catch (PDOException $e) {
            // Erro na conexão com o banco de dados
            echo 'Erro na conexão com o banco de dados: ' . $e->getMessage();
        }
    } 

 // para atualizar situação dos membros
     else { 
        try{

         // Prepara a consulta SQL de atualização
        $sql = "UPDATE pessoa 
                SET status_solicit = '$acao' 
                WHERE id = '$idsolicit'";
        $consulta = $conexao->prepare($sql);

        // Executa a consulta de atualização
        $consulta->execute();

        if ($consulta->rowCount() > 0) {
            header('location: area-logada.php');
            exit;
        }
        } catch (PDOException $e) {
            // Erro na conexão com o banco de dados
            echo 'Erro na conexão com o banco de dados: ' . $e->getMessage();
        }
    }
?>
