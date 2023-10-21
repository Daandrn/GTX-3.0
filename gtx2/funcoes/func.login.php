<?php 
/* 
Verifica as credenciais do usuário no banco 
*/
function login($nick, $password){
    
    require __DIR__ . "/../configuracao/conexao.php";

    try{
        $sql = "SELECT * FROM pessoa WHERE nick = :nick AND status_solicit in (0, 1, 4)";
        $consulta = $conexao->prepare($sql);
        $consulta->bindParam(':nick', $nick);
        $consulta->execute();
         
        if($consulta->rowCount() > 0){
    
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

            // se a consulta retornar pessoa com nick e senha correta, que seja membro ou adm, efetua login.
            if($nick == $resultado['nick'] && $password == $resultado['senha'] && ($resultado['status_solicit'] == 1 || $resultado['status_solicit'] == 4)){
                session_start();
                $_SESSION = array (
                    'nome' => $resultado['nome'],
                    'id_sessao' => $resultado['id'],
                    'nick' => $resultado['nick']
                );
                $mensagem = "Login efetuado com sucesso!";
                header("location: /../control/control.arealogada.php");
                exit;
            }
            // se a consulta retornar pessoa com cuja solicitação ainda esta pendente, retorna aviso.
            elseif ($resultado['status_solicit'] == 0) {
                $mensagem = "Aguardando aprovação!";
            }
            // se a consulta retornar pessoa com cuja senha esteja incorreta, retorna erro.
            elseif ($password != $resultado['senha']) {
                $mensagem = "Senha incorreta!";
            }
            
        } 
        // Se a consulta nao localizar usuário, retorna erro
        else {

            $mensagem = "Usuário não encontrado!";
        }
    }catch (PDOException $e) {
        echo "Erro no banco de dados: ". $e->getMessage();
    }

    return $mensagem;
}

?>