<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GTX</title>
    <link rel="stylesheet" href="/css/stylegtx.css">
    <link rel="shortcut icon" href="/css/imagens/logotrans.png" type="image/x-png">
</head>
<body>
    <header>
        <div class="cabecalho">
            <h1>GHOST TÓXIC TEAM</h1>
        </div>
        <div class="navegador">
            <nav>
                <ul>
                    <li><a href="/control/control.inicio.php" >Inicio</a></li>
                    <li><a href="/control/control.arealogada.php">Área logada</a></li>
                    <li><a href="/control/control.saladevideos.php">Sala de videos</a></li>
                    <li><a href="/control/control.membros.php">Membros</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="principal">
        <div id="separador">
            <span id="formularios">
                <div id="login">
                    <h1>Já sou membro</h1>
                    <form name="formlogin" method="get">
                        <div>
                            <label for="nick">Login: </label>
                            <input type="text" name="nick" id="nick" maxlength="30" size="30" pattern="[a-zA-Z0-9]*" placeholder="nickname" title="Insira seu nick sem espaços ou caracteres especiais." required>
                        </div>
                        <div>
                        <label for="senha">Senha: </label>
                            <input type="password" name="senha" id="senha" maxlength="10" size="10" pattern="[0-9]*" placeholder="Senha" title="Insira sua senha numérica." required>
                        </div>
                        <div>
                            <input type="submit" value="Login" id="login">
                            <button onclick="window.location.href='/../control/control.recuperasenha.php'";>Esqueci senha</button>
                        </div>
                    </form>
                </div>
                <div id="quemsomos">
                    <h1>Quem somos</h1>
                    <p>O Ghost Tóxic é um time dedicado ao battlefield 2042, formado por brasileiros para jogar
                            casual&shy;mente e enfrentar outras equipes nos modos Rush x4 e Tatical conquest x6.</p>
                        <p><a href="https://discord.gg/M4Bet5sCyh" target="_blank">Nosso discord</a></p>
                </div>
                <div id="recrut">
                    <h1>Quero fazer parte</h1>
                    <form name="formrecrut" method="get">
                        <div>
                            <label for="nome">Nome: </label>
                            <input type="text" name="nome" id="nome" maxlength="40" size="40" pattern="[A-Za-z\s']+" placeholder="Nome" title="Insira seu nome sem caracteres especiais." required>
                        </div>
                        <div>
                            <label for="plataforma">Plataforma: </label>
                            <select name="plataforma" id="plataforma" required>
                                <option value=""></option>
                                <?foreach($plataforma as $plat):?>
                                    <option value="<? echo $plat['id'];?>"><?echo $plat['descricao'];?></option>
                                <?endforeach;?>
                            </select>
                        </div>
                        <div>
                        <label for="nick">Nick: </label>
                            <input type="text" name="nick" id="nick" maxlength="40" size="40" pattern="[a-zA-Z0-9]*" placeholder="Nickname" title="Insira seu nick/origin." required>
                        </div>
                        <div>
                            <input type="submit" value="Solicitar recrutamento" id="solicitar">
                        </div>
                    </form>
                </div>
            </span>
        </div>
        <div id="imagemind">
            <img src="/css/imagens/logotrans.png">
        </div>
    </main>
    <footer>
        <p>Ghost tóxic team</p>
        <p>Todos os direitos reservados</p>
        <p>2023</p>
    </footer>
</body>
</html>