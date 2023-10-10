<?php 


function login($nick, $password){
    
    require __DIR__ . "/../configuracao/conexao.php";

    try{
        $sql = "SELECT * FROM pessoa WHERE nick = :nick";
        $consulta = $conexao->prepare($sql);
        $consulta->bindParam(':nick', $nick);
        $consulta->execute();
    
        if($consulta->rowCount() > 0){
    
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            if($nick == $resultado['nick'] && $password == $resultado['senha']){
                session_start();
                $_SESSION = array (
                    'nome' => $resultado['nome'],
                    'id' => $resultado['id'],
                    'nick' => $resultado['nick']
                );
                header("location: /../control/control.arealogada.php");
                exit;
            }
        } else{
            $mensagem = "Usuário não encontrado!";
        }
    }catch (PDOException $e) {
        echo "Erro de banco de dados: ". $e->getMessage();
    }

    return array($nick, $password, $mensagem);
}

?>