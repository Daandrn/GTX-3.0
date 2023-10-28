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
                        <input type="text" name="nickStream" value="<?php echo $dadoStream['nickStream']; ?>" placeholder="Nickstream">
                    </div>
                    <div>
                        <label for="linkstream">Link canal</label>
                        <input type="text" name="linkStream" value="<?php echo $dadoStream['linkCanal']; ?>" placeholder="link">
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
                    <span id="salvarStream">
                        <input type="hidden" name="formLogado" value="canalStream">
                        <input type="submit" value="Salvar">
                    </span>
                </form>
            </div>
            <div id="perfil">
                <div>
                    <form method="POST">
                        <h3>Perfil</h3>
                        <div>
                            <label for="">Nick/origin</label>
                            <input type="text" name="origin" value="<?php echo $nickPerfil?>" required>
                        </div>
                        <input type="hidden" name="formLogado" value="perfilNick">
                        <input type="submit" value="Salvar Nick" id="salvarPerfil">
                    </form>
                </div>
                <div>
                    <form method="POST">
                        <div>
                            <label for="">Nova senha</label>
                            <input type="text" name="senha" id="" placeholder="Nova senha" required>
                        </div>
                        <input type="hidden" name="formLogado" value="perfilSenha">
                        <input type="submit" value="Salvar Senha" id="salvarPerfil">
                    </form>
                </div>
            </div>
        </div>
    </main>
    <footer id="rodapeLogado">
        <div>
            <p>Ghost tóxic team&trade;</p>
            <p>Todos os direitos reservados&copy;</p>
            <p>2023</p>
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