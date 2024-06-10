<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GTX</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="shortcut icon" href="/Public/css/imagens/logotrans.png" type="image/x-png">
</head>

<body class="bodyPrincipal">
    <header>
        <div class="cabecalho">
            <h1>GHOST TÓXIC TEAM</h1>
        </div>
        <div class="navegador">
            <nav>
                <ul>
                    <li><a class="aNavegador" href="{{ Route('inicio') }}">Inicio</a></li>
                    <li><a class="aNavegador" href="{{ Route('arealogada') }}">Área logada</a></li>
                    <li><a class="aNavegador" href="{{ Route('saladevideos') }}">Sala de videos</a></li>
                    <li><a class="aNavegador" href="{{ Route('listaMembros') }}">Membros</a></li>
                    <li>
                        <form action="{{ Route('sair') }}" method="POST">
                            @csrf()
                            @method('POST')
                            <input type="hidden" name="formLogado" value="form_sair">
                            <input type="submit" value="Sair" id="botaoSair">
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="principal">
        <h1 id="boasVindas">
            Seja bem vindo, {{ $nomeSessao }}!
        </h1>
        <div id="dadosPessoais">
            <div id="canalStream">
                <form action="{{ Route('alteracanalstream') }}" method="POST">
                    @csrf()
                    @method('PATCH')
                    <h3>Canal de Stream</h3>
                    <div>
                        <label for="nick_stream">Nick stream</label>
                        <input type="text" name="nick_stream" id="nick_stream" value="{{ (old('nick_stream') ?? $dadoStream['nickStream']) }}" placeholder="Nickstream" maxlength="20">
                    </div>
                    <div>
                        <label for="link_canal">Link canal</label>
                        <input type="text" name="link_canal" id="link_canal" value="{{ (old('link_canal') ?? $dadoStream['linkCanal']) }}" placeholder="twitch.tv" title="Insira o link do seu canal sem 'https://'. Ex.: www.twitch.tv ou twitch.tv." maxlength="50">
                    </div>
                    <div>
                        <label for="plataforma">Plataforma</label>
                        <select name="plataforma" id="plataforma">

                            <option value=""></option>

                            @foreach ($plataformasStream as $plat)
                                <option value="{{ $plat->id }}" @selected(($plat->id == (old('plataforma') ?? $dadoStream['plataforma'])))>{{ $plat->descricao }}</option>
                            @endforeach

                        </select>
                    </div>

                    <div id="baguncinha">

                        <span id="salvarStream">
                            <input type="hidden" name="formLogado" value="canalStream">
                            <input type="submit" value="Salvar">
                        </span>
                </form>
                <span>
                    <form action="{{ Route('limpacanalstream') }}" method="POST">
                        @csrf()
                        @method('PATCH')
                        <input type="hidden" name="formLogado" value="excluiCanalStream">
                        <input type="submit" value="Excluir">
                    </form>
                </span>

            </div>
        </div>
        <div id="perfil">
            <div>
                <form action="{{ Route('alteranick') }}" method="POST">
                    @csrf()
                    @method('PATCH')
                    <h3>Perfil</h3>
                    <div>
                        <label for="nick">Nick/origin</label>
                        <input type="text" name="nick" id="nick" value="{{ $nickPerfil ?? '' }}" maxlength="15" pattern="[a-zA-Z0-9]*">
                    </div>
                    <input type="hidden" name="formLogado" value="perfilNick">
                    <input type="submit" value="Salvar Nick" class="salvarPerfil">
                </form>
            </div>
            <div>
                <form action="{{ Route('alterasenha') }}" method="POST">
                    @csrf()
                    @method('PATCH')
                    <div>
                        <label for="senha">Nova senha</label>
                        <input type="password" name="senha" id="senha" placeholder="Nova senha" maxlength="10" title="Insira sua senha numérica.">
                    </div>
                    <input type="hidden" name="formLogado" value="perfilSenha">
                    <input type="submit" value="Salvar Senha" class="salvarPerfil">
                </form>
            </div>
        </div>
        </div>
        <div id="notice">
            <section id=tabelasLogado>
                <div id="membrosAdm">
                    <table id="tabAdmMembros">
                        <caption>
                            Membros
                        </caption>
                        <tr>
                            <th>Nome</th>
                            <th>Nick</th>
                            <th>Plataforma</th>
                            <th>Status Membro</th>
                            <th>Ação</th>
                        </tr>
                        @if ($listaMembros->isNotEmpty())
                            @foreach ($listaMembros as $membros)
                                <tr>
                                    <td class="formatNome">{{ $membros->nome }}</td>
                                    <td class="formatNick">{{ $membros->nick }}</td>
                                    <td class="formatPlataforma">{{ $membros->plataforma_game }}</td>
                                    <td class="formatStatus">{{ $membros->cargo_membro }}</td>
                                    <td class="formatAcao">
                                        @if (session()->get('statusMembro') === 4)
                                            <form action="{{ Route('alterastatusmembro') }}" method="post">
                                                @csrf()
                                                @method('PATCH')
                                                <div>
                                                    <select name="acaoMembrosAdm[]">
                                                        <option value="">Selecione</option>
                                                        <option value="4">Administrador</option>
                                                        <option value="1">Membro</option>
                                                        <option value="3">Expulsar</option>
                                                    </select>
                                                    <input type="submit" name="acaoMembrosAdm[]" value="Salvar">
                                                    <input type="hidden" name="acaoMembrosAdm[]" value="{{ $membros->id }}">
                                                </div>
                                            </form>
                                        @endif
                                        @if (in_array(session()->get('statusMembro'), [1, 4], true))
                                            <form action="/" method="post">
                                                @csrf()
                                                @method('POST')
                                                <input type="submit" value="Elogiar">
                                                <input type="submit" value="Xingar">
                                                <input type="hidden" name="acaoMembros" value="{{ $membros->id }}">
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="formatNoresult" colspan="5">Nenhum membro econtrado!</td>
                            </tr>
                        @endif
                    </table>
                </div>
                @if (session()->get('statusMembro') === 4)
                    <div id="recrutAdm">
                        <table id="tabAdmMembros">
                            <caption>
                                Solicitações
                            </caption>
                            <tr>
                                <th>Nome</th>
                                <th>Nick</th>
                                <th>Plataforma</th>
                                <th>Status Solicitação</th>
                                <th>Ação</th>
                            </tr>
                            @if ($listaRecrut->isNotEmpty())
                                @foreach ($listaRecrut as $recrut)
                                    <tr>
                                        <td class="formatNome">{{ $recrut->nome }}</td>
                                        <td class="formatNick">{{ $recrut->nick }}</td>
                                        <td class="formatPlataforma">{{ $recrut->plataforma }}</td>
                                        <td class="formatStatus">{{ $recrut->status_solicit }}</td>
                                        <td class="formatAcao">
                                            <form action="{{ Route('alterastatusmembro') }}" method="post">
                                                @csrf()
                                                @method('PATCH')
                                                <div>
                                                    <select name="acaoMembrosAdm[]">
                                                        <option value="">Selecione</option>
                                                        <option value="1">Aceitar</option>
                                                        <option value="2">Rejeitar</option>
                                                    </select>
                                                    <input type="submit" name="acaoMembrosAdm[]" value="Salvar">
                                                    <input type="hidden" name="acaoMembrosAdm[]" value="{{ $recrut->id }}">
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="formatNoresult" colspan="5">Nenhuma solicitação pendente!</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                @endif
                @if (session()->get('statusMembro') === 4)
                    <div id="recusadosAdm">
                        <table id="tabAdmMembros">
                            <caption>
                                Rejeitados e expulsos
                            </caption>
                            <tr>
                                <th>Nome</th>
                                <th>Nick</th>
                                <th>Plataforma</th>
                                <th>Status Solicitação</th>
                                <th>Ação</th>
                            </tr>
                            @if ($listaRejeitados->isNotEmpty())
                                @foreach ($listaRejeitados as $rejeitados)
                                    <tr>
                                        <td class="formatNome">{{ $rejeitados->nome }}</td>
                                        <td class="formatNick">{{ $rejeitados->nick }}</td>
                                        <td class="formatPlataforma">{{ $rejeitados->plataforma }}</td>
                                        <td class="formatStatus">{{ $rejeitados->status_solicit }}</td>
                                        <td class="formatAcao">
                                            <form action="{{ Route('alterastatusmembro') }}" method="post">
                                                @csrf()
                                                @method('PATCH')
                                                <div>
                                                    <select name="acaoMembrosAdm[]">
                                                        <option value="">Selecione</option>
                                                        <option value="1">Recrutar</option>
                                                    </select>
                                                    <input type="submit" name="acaoMembrosAdm[]" value="Salvar">
                                                    <input type="hidden" name="acaoMembrosAdm[]" value="{{ $rejeitados->id }}">
                                                </div>
                                            </form>
                                            <form action="{{ Route('excluir') }}" method="post">
                                                @csrf()
                                                @method('POST')
                                                <div>
                                                    <input type="submit" name="acaoMembrosAdm[]" value="Excluir">
                                                    <input type="hidden" name="acaoMembrosAdm[]" value="{{ $rejeitados->id }}">
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="formatNoresult" colspan="5">Nenhum membro expulso/rejeitado!</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                @endif
                @if (session()->get('statusMembro') === 4)
                    <div id="recuperaSenha">
                        <table id="tabAdmMembros">
                            <caption>
                                Solicitação de nova senha
                            </caption>
                            <tr>
                                <th>Nome</th>
                                <th>Nick</th>
                                <th>Data</th>
                                <th>Status Solicitação</th>
                                <th>Ação</th>
                            </tr>
                            @if ($listaNovaSenha->isNotEmpty())
                                @foreach ($listaNovaSenha as $novaSenha)
                                    <tr>
                                        <td class="formatNome">{{ $novaSenha->nome }}</td>
                                        <td class="formatNick">{{ $novaSenha->nick }}</td>
                                        <td class="formatPlataforma">{{ (new DateTime($novaSenha->data_solicit))->format('d/m/y') }}</td>
                                        <td class="formatStatus">{{ $novaSenha->status_senha }}</td>
                                        <td class="formatAcao">
                                            <div id="formsAcaoNovaSenha">
                                                <form action="{{ Route('aprovasenha') }}" method="post">
                                                    @csrf()
                                                    @method('POST')
                                                    <div>
                                                        <input type="submit" name="acaoAlteraSenha" value="Aprovar">
                                                        <input type="hidden" name="member_id" id="member_id" value="{{ $novaSenha->member_id }}">
                                                        <input type="hidden" name="id" id="id" value="{{ $novaSenha->id }}">
                                                    </div>
                                                </form>
                                                <form action="{{ Route('reprovasenha') }}" method="post">
                                                    @csrf()
                                                    @method('POST')
                                                    <div>
                                                        <input type="submit" name="acaoAlteraSenha" value="Reprovar">
                                                        <input type="hidden" name="member_id" id="member_id" value="{{ $novaSenha->member_id }}">
                                                        <input type="hidden" name="id" id="id" value="{{ $novaSenha->id }}">
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="formatNoresult" colspan="5">Nenhuma solicitação pendente</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                @endif
            </section>
        </div>
        <x-alert/>
    </main>

    @include('partials.footer')
