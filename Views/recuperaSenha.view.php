<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/gtx2/css/styleFrame.css">
    <title>Recupera senha</title>
</head>
<body id="bodyRecuperaSenha">
    <div id="divRecuperaSenha">
        <h4>Recuperação de senha</h4>
        <form action="/gtx2/control/control.recuperaSenha.php" method="post">
            <div>
                <label for="origin">Nick/origin</label>
                <input type="text" name="origin" id="origin" maxlength="15" size="30" pattern="[a-zA-Z0-9]*" placeholder="Nick/origin" title="Insira seu nick sem espaços ou caracteres especiais.">
            </div>
            <div>
                <label for="newSenha">Nova senha</label>
                <input type="password" name="newSenha" id="newSenha" maxlength="10" size="10" pattern="[0-9]*" placeholder="Senha" title="Insira sua nova senha numérica." autocomplete="off">
            </div>
            <input type="hidden" name="recuperaSenhaFrame" value="recuperarSenha">
            <input type="submit" id="botaoRecuperaSenha" value="Recuperar senha">
        </form>
    </div>
    <script>
        let responseRecuperaSenha = <?php 
                                        $alert = isset($responseRecuperaSenha) ? $responseRecuperaSenha : 1;
                                        echo json_encode($alert); 
                                    ?>
            
        let responseExistePessoa = <?php 
                                        $alert2 = isset($responseExistePessoa) ? $responseExistePessoa : 1;
                                         echo json_encode($alert2); 
                                    ?>

        let responseExisteSolicit = <?php 
                                        $alert3 = isset($responseExisteSolicit) ? $responseExisteSolicit : 1;
                                         echo json_encode($alert3); 
                                    ?>

        if (responseExistePessoa != 1) {
            alert(responseExistePessoa)
        }
        if ((responseRecuperaSenha) != 1) {
            alert(responseRecuperaSenha)
        }
        if ((responseExisteSolicit) != 1) {
            alert(responseExisteSolicit)
        }
        
    </script>
</body>
</html>
