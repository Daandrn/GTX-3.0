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
                        <input type="text" name="nickStream" value="<?php echo $dadoStream['nickStream']; ?>" placeholder="Nickstream" maxlength="20">
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
                            <input type="text" name="origin" value="<?php echo $nickPerfil?>" maxlength="15" pattern="[a-zA-Z0-9]*">
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
        <div id="notice">
            <aside id="eventosLogado">
                <article>
                    <h1>Noticias</h1>
                </article>
                <article>
                    <h1>Eventos</h1>
                </article>
            </aside>
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
                        <?php if (!empty($listaMembros)): ?>
                        <?php foreach ($listaMembros as $membros): ?>
                        <tr>
                            <td class="formatNome"><?php echo $membros['nome']; ?></td>
                            <td class="formatNick"><?php echo $membros['nick']; ?></td>
                            <td class="formatPlataforma"><?php echo $membros['plataforma']; ?></td>
                            <td class="formatStatus"><?php echo $membros['status_membro']; ?></td>
                            <td class="formatAcao"></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td class="formatNoresult" colspan="5">Nenhum membro econtrado!</td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
                <?php if ($_SESSION['statusMembro'] == 4) : ?>
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
                        <?php if (!empty($listaRecrut)): ?>
                        <?php foreach ($listaRecrut as $recrut): ?>
                        <tr>
                            <td class="formatNome"><?php echo $recrut['nome']; ?></td>
                            <td class="formatNick"><?php echo $recrut['nick']; ?></td>
                            <td class="formatPlataforma"><?php echo $recrut['plataforma']; ?></td>
                            <td class="formatStatus"><?php echo $recrut['status_membro']; ?></td>
                            <td class="formatAcao"></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td class="formatNoresult" colspan="5">Nenhuma solicitação pendente!</td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
                <?php endif; ?>
                <?php if ($_SESSION['statusMembro'] == 4) : ?>
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
                        <?php if (!empty($listaRejeitados)): ?>
                        <?php foreach ($listaRejeitados as $rejeitados): ?>
                        <tr>
                            <td class="formatNome"><?php echo $rejeitados['nome']; ?></td>
                            <td class="formatNick"><?php echo $rejeitados['nick']; ?></td>
                            <td class="formatPlataforma"><?php echo $rejeitados['plataforma']; ?></td>
                            <td class="formatStatus"><?php echo $rejeitados['status_membro']; ?></td>
                            <td class="formatAcao"></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td class="formatNoresult" colspan="5">Nenhum membro expulso/rejeitado!</td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
                <?php endif; ?>
                <?php if ($_SESSION['statusMembro'] == 4) : ?>
                <div id="recuperaSenha">
                    <table id="tabAdmMembros">
                        <caption>
                            Solicitação de nova senha
                        </caption>
                        <tr>
                            <th>Nome</th>
                            <th>Nick</th>
                            <th>Plataforma</th>
                            <th>Status Solicitação</th>
                            <th>Ação</th>
                        </tr>
                        <?php if (!empty($listaNovaSenha)): ?>
                        <?php foreach ($listaNovaSenha as $novaSenha): ?>
                        <tr>
                            <td class="formatNome"><?php //echo $novaSenha['nome']; ?></td>
                            <td class="formatNick"><?php echo $novaSenha['nick']; ?></td>
                            <td class="formatPlataforma"><?php //echo $novaSenha['plataforma']; ?></td>
                            <td class="formatStatusSenha"><?php echo $novaSenha['statusSenha']; ?></td>
                            <td class="formatAcao"></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td class="formatNoresult" colspan="5">Nenhuma solicitação pendente</td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
                <?php endif; ?>
            </section>
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