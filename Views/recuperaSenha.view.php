<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Public/Css/styleFrame.css">
    <title>Recupera senha</title>
</head>

<body id="bodyRecuperaSenha">
    <div id="divRecuperaSenha">
        <h4>Recuperação de senha</h4>
        <form method="post" id="formRecuperaSenha">
            <div>
                <label for="nick">Nick/origin</label>
                <input type="text" name="nick" id="nick" maxlength="15" size="30" pattern="[a-zA-Z0-9]*" placeholder="Nick/origin" title="Insira seu nick sem espaços ou caracteres especiais.">
            </div>
            <div>
                <label for="nova_senha">Nova senha</label>
                <input type="password" name="nova_senha" id="nova_senha" maxlength="10" size="10" placeholder="Senha" title="Insira sua nova senha numérica." autocomplete="off">
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

        const formRecuperaSenha = document.querySelector('#formRecuperaSenha').addEventListener('submit', function (event) {
            event.preventDefault();

            const xhr = new XMLHttpRequest;

            let nick = document.querySelector('#nick').value;
            let nova_senha = document.querySelector('#nova_senha').value;

            let data = JSON.stringify({'nick': nick, 'nova_senha': nova_senha});

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    let response = JSON.parse(xhr.response);
                    alert(response.message);
                }
            };

            xhr.open('POST', '/recuperasenha');

            xhr.send(data);
        });
    </script>
</body>

</html>