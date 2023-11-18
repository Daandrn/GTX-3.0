<?php

/*
 * Inclui o arquivo de conexão com o banco de dados.
 */
require_once 'dbConnection.php';

/**
 * Função para verificar as credenciais do usuário e realizar o login.
 *
 * @param string $nick O nickname do usuário.
 * @param string $password A senha do usuário.
 * @return array Retorna um array com o status do login, mensagem de erro/sucesso e dados do usuário.
 */
function login($nick, $password) {
    // Obtém a conexão com o banco de dados.
    $conexao = getDbConnection();

    // Predefine um resultado padrão para falha de login.
    $resultado = ["sucess" => false, "message" => "Usuario ou senha incorreta", "redirect" => "" ];

    try {
        // Prepara a consulta SQL para buscar o usuário pelo nick e status.
        $sql = "SELECT * FROM pessoa WHERE nick = :nick AND status_solicit in (0, 1, 4)";
        $consulta = $conexao->prepare($sql);
        $consulta->bindParam(':nick', $nick);
        $consulta->execute();

        // Verifica se algum usuário foi encontrado.
        if ($consulta->rowCount() > 0) {
            // Obtém os dados do usuário.
            $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

            // Verifica a senha e o status do usuário.
            if (password_verify($password, $usuario['senha'])) {
                // Usuário com status de membro ou administrador.
                if ($usuario['status_solicit'] === 1 || $usuario['status_solicit'] === 4) {
                    // Prepara o resultado para um login bem-sucedido.
                    $resultado = [
                        "sucess" => true,
                        "message" => '',
                        "redirect" => "/gtx2/control/control.arealogada.php",
                        "userData" => [
                            "nome" => $usuario['nome'],
                            "id_sessao" => $usuario['id'],
                            "nick" => $usuario['nick'],
                            "statusMembro" => $usuario['status_solicit']
                        ]
                    ];
                } elseif ($usuario['status_solicit'] == 0) {
                    // Usuário com status de aguardando aprovação.
                    $resultado["message"] = "Aguardando aprovação! Entre em contato com um dos administradores ou aguarde.";
                }
            }
        }
    } catch (PDOException $e) {
        // Em caso de erro de banco de dados, registra o erro e define uma mensagem genérica.
        error_log("Erro no banco de dados: " . $e->getMessage());
        $resultado["message"] = 'Ocorreu um erro no sistema. Por favor, tente novamente mais tarde';
    }

    // Retorna o resultado da tentativa de login.
    return $resultado;
}

?>
