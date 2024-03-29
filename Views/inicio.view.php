<?php include __DIR__.'/parts/top.php';?>

<main class="principal">
    <div id="separador">
        <span id="formularios">
            <div id="login">
                <h1>Sou membro</h1>
                <form name="formlogin" method="POST">
                    <div>
                        <label for="nick_login">Login: </label>
                        <input type="text" name="nick_login" id="nick_login" maxlength="15" size="30" pattern="[a-zA-Z0-9]*" placeholder="Nick/origin" title="Insira seu nick sem espaços ou caracteres especiais." required>
                    </div>
                    <div>
                    <label for="senha_login">Senha: </label>
                        <input type="password" name="senha_login" id="senha_login" maxlength="10" size="10" pattern="[0-9]*" placeholder="Senha" title="Insira sua senha numérica." autocomplete="off" required>
                    </div>
                    <div>
                        <input type="hidden" name="formInicio" value="form_login">
                        <input type="submit" value="Login" id="login">
                        <button onclick="window.location.href='/gtx2/control/control.inicio.php?recuperaSenhaFrame=1'";>Esqueci senha</button>
                    </div>
                </form>
            </div>
            <?php if (isset($_GET['recuperaSenhaFrame']) && $_GET['recuperaSenhaFrame'] == 1): ?>
                <span id="recuperaSenhaFrame">
                    <iframe src="/gtx2/view/view.recuperaSenha.php" frameborder="2" id="frameRecuperaSenha"></iframe>
                </span>
            <?php endif; ?>
            <div id="quemsomos">
                <h1>Quem somos</h1>
                <p>O Ghost Tóxic é um time dedicado ao battlefield 2042, formado por brasileiros para jogar
                    casual&shy;mente e enfrentar outras equipes nos modos Rush x4 e Tatical conquest x6.</p>
                <p><a href="https://discord.gg/M4Bet5sCyh" target="_blank">Nosso discord</a></p>
            </div>
            <div id="recrut">
                <h1>Quero fazer parte</h1>
                <form name="formrecrut" method="POST">
                    <div>
                        <label for="nome_recrut">Nome: </label>
                        <input type="text" name="nome_recrut" id="nome_recrut" maxlength="24" size="40" pattern="[A-Za-z\s']+" placeholder="Nome" title="Insira seu nome sem caracteres especiais." required>
                    </div>
                    <div>
                        <label for="nick_recrut">Nick: </label>
                        <input type="text" name="nick_recrut" id="nick_recrut" maxlength="15" size="40" pattern="[a-zA-Z0-9]*" placeholder="Nick/origin" title="Insira seu nick/origin." required>
                    </div>
                    <div>
                        <label for="plataforma_recrut">Plataforma: </label>
                        <select name="plataforma_recrut" id="plataforma_recrut" required>
                            <option value=""></option>
                            <option value="1">PC</option>
                            <option value="2">Xbox Séries</option>
                            <option value="3">Ps5</option>
                        </select>
                    </div>
                    <div>
                        <input type="hidden" name="formInicio" value="form_recrut">
                        <input type="submit" value="Solicitar recrutamento" id="solicitar">
                    </div>
                </form>
                <div id="respostaRecrut">
                </div>
            </div>
        </span>
    </div>
    <div id="imagemind">
        <img src="/public/css/imagens/logotrans.png">
    </div>
    <script src="/Public/Js/alert.js"></script>
</main>

<?php include __DIR__.'/parts/footer.php';?>