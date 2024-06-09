@include('partials.top')

<main class="principal">
    <div id="separador">
        <span id="formularios">
            <div id="login">
                <h1>Sou membro</h1>
                <form action="/login" name="formlogin" method="POST">
                    @csrf()
                    @method('POST')
                    <div>
                        <label for="nick_login">Login: </label>
                        <input type="text" name="nick_login" id="nick_login" maxlength="15" size="30" pattern="[a-zA-Z0-9]*" placeholder="Nick/origin" title="Insira seu nick sem espaços ou caracteres especiais." value="{{ old('nick_login') }}">
                    </div>
                    <div>
                        <label for="senha_login">Senha: </label>
                        <input type="password" name="senha_login" id="senha_login" maxlength="10" size="10" placeholder="Senha" title="Insira sua senha." autocomplete="off" value="{{ old('senha_login') }}">
                    </div>
                    <div>
                        <input type="hidden" name="formInicio" value="form_login">
                        <input type="submit" value="Login" id="login">
                        <button type="button" id="buttonNovaSenha">Nova senha</button>
                    </div>
                </form>
            </div>
            <span id="recuperaSenhaFrame" style="display: none;">
                <div id="divBotaoFecharRecuperaSenha"><button type="button" id="botaoFecharRecuperaSenha" ><b>X</b></button></div>
                <iframe src="/Views/recuperaSenha.view.php" frameborder="2" id="frameRecuperaSenha"></iframe>
            </span>
            <div id="quemsomos">
                <h1>Quem somos</h1>
                <p>O Ghost Tóxic é um time dedicado ao battlefield 2042, formado por brasileiros para jogar
                    casual&shy;mente e enfrentar outras equipes nos modos Rush x4 e Tatical conquest x6.</p>
                <p><a href="https://discord.gg/M4Bet5sCyh" target="_blank">Nosso discord</a></p>
            </div>
            <div id="recrut">
                <h1>Quero fazer parte</h1>
                <form action="{{ Route('novo') }}" name="formrecrut" method="POST">
                    @csrf()
                    @method('POST')
                    <div>
                        <label for="nome_recrut">Nome: </label>
                        <input type="text" name="nome_recrut" id="nome_recrut" maxlength="24" size="40" pattern="[A-Za-z\s'ãáâéêíõôóúÃÁÂÉÊÍÕÔÓÚ]+" placeholder="Nome" title="Insira seu nome." value="{{ old('nome_recrut') }}">
                    </div>
                    <div>
                        <label for="nick_recrut">Nick: </label>
                        <input type="text" name="nick_recrut" id="nick_recrut" maxlength="15" size="40" pattern="[a-zA-Z0-9]*" placeholder="Nick/origin" title="Insira seu nick/origin." value="{{ old('nick_recrut') }}">
                    </div>
                    <div>
                        <label for="plataforma_recrut">Plataforma: </label>
                        <select name="plataforma_recrut" id="plataforma_recrut">
                            <option value=""  @selected(old('plataforma_recrut') === '')></option>
                            <option value="1" @selected(old('plataforma_recrut') === '1')>PC</option>
                            <option value="2" @selected(old('plataforma_recrut') === '2')>Xbox Séries</option>
                            <option value="3" @selected(old('plataforma_recrut') === '3')>Ps5</option>
                        </select>
                    </div>
                    <div>
                        <input type="hidden" name="formInicio" value="form_recrut">
                        <input type="submit" value="Solicitar cadastro" id="solicitar">
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
    <x-alert/>
    <script>
        let recuperaSenhaFrame = document.querySelector('#recuperaSenhaFrame');

        const buttonNovaSenha = document.querySelector('#buttonNovaSenha').addEventListener('click', function() {
            recuperaSenhaFrame.style.display = '';
        });

        const botaoFecharRecuperaSenha = document.querySelector('#botaoFecharRecuperaSenha').addEventListener('click', function() {
            recuperaSenhaFrame.style.display = 'none';
        });
    </script>
</main>

@include('partials.footer')