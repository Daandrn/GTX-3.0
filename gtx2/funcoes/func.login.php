<?php 

require_once __DIR__ . "/../configuracao/connection.php";

use function gtx2\configuracao\connection;

/* 
Verifica as credenciais do usuário no banco 
*/
function login(string $nick, int $password)
{
    try {
        $sql = "SELECT * FROM pessoa WHERE nick = :nick AND status_solicit in (0, 1, 4)";
        $consulta = connection()->prepare($sql);
        $consulta->bindParam(':nick', $nick, PDO::PARAM_STR);
        $consulta->execute();
         
        if ($consulta->rowCount() > 0) {
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

            // se a consulta retornar pessoa com nick e senha correta, que seja membro ou adm, efetua login.
            if (
                $nick == $resultado['nick'] && 
                $password == $resultado['senha'] && 
                ($resultado['status_solicit'] == 1 || $resultado['status_solicit'] == 4)
                ) {
                session_start();
                $_SESSION = array (
                    "nome" => $resultado['nome'],
                    "id_sessao" => $resultado['id'],
                    "nick" => $resultado['nick'],
                    "statusMembro" => $resultado['status_solicit']
                );
                header("location: /gtx2/control/control.arealogada.php");
                
                exit;
            }

            // se a consulta retornar pessoa com cuja solicitação ainda esta pendente, retorna aviso.
            elseif ($resultado['status_solicit'] == 0) {
                return "Aguardando aprovação! entre em contato com um dos administradores ou aguarde.";
            }

            // se a consulta retornar pessoa com cuja senha esteja incorreta, retorna erro.
            elseif ($password != $resultado['senha']) {
                return "Senha incorreta! tente novamente ou use o esqueci senha.";
            }
        } 

        // Se a consulta nao localizar usuário, retorna erro
        else {
            return "Usuário não encontrado!";
        }
    } catch (PDOException $error) {
        return "Erro ao verificar dados do usuário no banco de dados: ". $error->getMessage();
    }
}