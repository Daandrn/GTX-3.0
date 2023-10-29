<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GTX</title>
    <link rel="stylesheet" href="/gtx2/css/stylegtx.css">
    <link rel="shortcut icon" href="/gtx2/css/imagens/logotrans.png" type="image/x-png">
</head>
<body>
    <header>
        <div class="cabecalho">
            <h1>GHOST TÓXIC TEAM</h1>
        </div>
        <div class="navegador">
            <nav>
                <ul>
                    <li><a class="aNavegador" href="/gtx2/control/control.inicio.php" >Inicio</a></li>
                    <li><a class="aNavegador" href="/gtx2/control/control.areaLogada.php">Área logada</a></li>
                    <li><a class="aNavegador" href="/gtx2/control/control.salaVideos.php">Sala de videos</a></li>
                    <li><a class="aNavegador" href="/gtx2/control/control.membros.php">Membros</a></li>
                    <li>
                        <form method="POST">
                            <input type="hidden" name="formLogado" value="form_sair" >
                            <input type="submit" value="Sair" id="botaoSair">
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="principal">
        <h1 id="boasVindas">
        Seja bem vindo, <?php echo $boasvindas;?>!
        </h1>
        <div id="dadosPessoais">
            <div id="canalStream">
                <form method="POST">
                    <h3>Canal Stream</h3>
                    <div>
                        <label for="nickStream">Nick stream</label>
                        <input type="text" name="nickStream" value="<?php echo $dadoStream['nickStream']; ?>" placeholder="Nickstream" maxlength="30">
                    </div>
                    <div>
                        <label for="linkStream">Link canal</label>
                        <input type="text" name="linkStream" value="<?php echo $dadoStream['linkCanal']; ?>" placeholder="twitch.tv" title="Insira o link do seu canal sem 'https://'. Ex.: www.twitch.tv ou twitch.tv." maxlength="50">
                    </div>
                    <div>
                        <label for="plataforma">Plataforma</label>
                        <select name="plataforma" id="">
                            <option value=""></option>
                            <?php foreach ($plataformasStream as $plat) : ?>
                            <option value="<?php echo $plat['id']?>" <?php if ($plat['id'] == $dadoStream['plataforma']) {echo "selected";} ?>><?php echo $plat['descricao']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div id="baguncinha">

                    <span id="salvarStream">
                        <input type="hidden" name="formLogado" value="canalStream">
                        <input type="submit" value="Salvar">
                    </span>
                </form>
                <span>
                    <form method="POST">
                        <input type="hidden" name="formLogado" value="excluiCanalStream">
                        <input type="submit" value="Excluir">
                    </form>
                </span>

                    </div>

                <script>

                    let respostaAlteraStream = <?php $alert = isset($responseStream) ? $responseStream : 1;
                                            echo json_encode($alert);
                                            ?>;

                    if (respostaAlteraStream != 1) {
                        alert(respostaAlteraStream)
                    }

                </script>
            </div>
            <div id="perfil">
                <div>
                    <form method="POST">
                        <h3>Perfil</h3>
                        <div>
                            <label for="">Nick/origin</label>
                            <input type="text" name="origin" value="<?php echo $nickPerfil?>" maxlength="20" pattern="[a-zA-Z0-9]*">
                        </div>
                        <input type="hidden" name="formLogado" value="perfilNick">
                        <input type="submit" value="Salvar Nick" class="salvarPerfil">
                    </form>
                    <script>

                        let respostaAlteraNick = <?php $alert = isset($responseAlteraNick) ? $responseAlteraNick : 1;
                                                echo json_encode($alert);
                                                ?>;

                        if (respostaAlteraNick != 1) {
                            alert(respostaAlteraNick)
                        }

                    </script>
                </div>
                <div>
                    <form method="POST">
                        <div>
                            <label for="novaSenha">Nova senha</label>
                            <input type="password" name="novaSenha" id="" pattern="[0-9]*" placeholder="Nova senha" maxlength="10" title="Insira sua senha numérica.">
                        </div>
                        <input type="hidden" name="formLogado" value="perfilSenha">
                        <input type="submit" value="Salvar Senha" class="salvarPerfil">
                    </form>
                <script>

                    let respostaAlteraSenha = <?php $alert = isset($responseAlteraSenha) ? $responseAlteraSenha : 1;
                                            echo json_encode($alert);
                                            ?>;

                    if (respostaAlteraSenha != 1) {
                        alert(respostaAlteraSenha)
                    }

                </script>
                </div>
            </div>
        </div>
    </main>
    <footer id="rodapeLogado">
        <div>
            <p>Ghost tóxic team&trade;</p>
            <p>Todos os direitos reservados&copy;</p>
            <p><a href="/Documentacao PHP/Index.html" target="_blank" rel="noopener noreferrer">Documentacao PHP</a></p>
        </div>
        <div id="versiona">
            <form method="post">
                <div>
                    <label for="versao">Versao</label>
                    <select name="versao">
                        <?php while ($resutado = $sql->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?php echo $resutado['id'];?>" <?php if ($resutado['selected'] == 1) {echo "selected";} ?>><?php echo $resutado['descricao'];?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                    <input type="hidden" name="formLogado" value="salvaVersao">
                    <input type="submit" value="Salvar">
            </form>
        </div>
    </footer>
</body>
</html>