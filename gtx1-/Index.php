<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <title>Ghost Tóxic Team</title>
    <link rel="stylesheet" href="_css/estilogtx.css">
    <link href="_css/imagemcss/logotrans.png" rel="shortcut icon" type="image/png">
</head>

<body>

    <header id="cabecalho"> 
        <div id="titulo">
            <h1>TEAM GHOST TÓXIC</h1>
        </div>
        <nav id="menu">
            <ul>
                <li><a href="Index.php">Inicio</a></li>
                <li><a href="solicitar-recrutamento.php">Solicitar recrutamento</a></li>
                <li><a href="sala-de-videos.php">Sala de videos</a></li>
                <li><a href="canais-dos-membros.php">Canais dos membros</a></li>
                <li><a href="membros.php">Membros</a></li>
            </ul>
        </nav>

    </header>

    <main id="interface">

        <div class="textos">
            <h1 id="maintitulo">Quem somos<h1>
                    <p>O Ghost Tóxic é um time dedicado ao battlefield 2042, formado por brasileiros para jogar
                        casual&shy;mente e enfrentar outras equipes nos modos Rush x4 e Tatical conquest x6</p>
                    <p><a href="https://discord.gg/GFRGKaRJ8" target="_blank">Nosso discord</a></p>
        </div>
        <section id="seclogin">
            <div class="formlogin">
                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <div>
                        <label for="nick">Nick:</label>
                        <input type="text" name="nick" pattern="[A-Za-z0-9]+(\s[A-Za-z0-9]+)*" maxlength="20"
                            title="Informe seu nick/origin." size="20" required>
                    </div>
                    <div>
                        <label for="senha">Senha: </label>
                        <input type="text" name="senha1" title="Digite a sua senha. Somente letras e numeros."
                            maxlength="10" pattern="[0-9A-Za-z]+" size="20" required>
                    </div>
                    <input type="submit" value="Login">
                </form>
                <div>
                    <button onclick="window.location.href='esqueci-senha.php'">Esqueci senha</button>
                </div>
            </div>
            <?php

            		// Criar a conexão com o PostgreSQL usando pdo 
					require __DIR__."/conexao.php";

					if ($_SERVER["REQUEST_METHOD"] == "POST") {

						try {
                            
                            // Obtém o login e a senha enviados pelo formulário - pc de casa
							$nick = $_POST['nick'];
							$senha = $_POST['senha1'];
                            
							// Prepara a consulta SQL para buscar o usuário com o login informado
							$consulta = $conexao->prepare("SELECT *
														FROM pessoa 
														WHERE nick = :nick");
							$consulta->bindParam(':nick', $nick);
							$consulta->execute();
                            
                            
							// Verifica se encontrou um usuário com o login informado
							if ($consulta->rowCount() > 0) {
                                $usuario = $consulta->fetch(PDO::FETCH_ASSOC);
								// Verifica se a senha está correta
								if ($senha == $usuario['senha'] && ($usuario['status_solicit'] === 4 || $usuario['status_solicit'] === 1)) {
                                    
                                    session_start();
                                    $_SESSION['nick'] = $nick;

									// Login bem-sucedido, redireciona para a area logada
									header('Location: area-logada.php');
									exit();
								} else {
									// Senha incorreta
									echo '<div>
											<h3>Senha incorreta!</h3> 
										</div>';
								}
							} else {
								// Usuário não encontrado
								echo '<div>
										<h3>Usuário não encontrado! </h3>
									</div>';
							}
						} catch (PDOException $e) {
							// Erro na conexão com o banco de dados
							echo 'Erro na conexão com o banco de dados: ' . $e->getMessage();
						}
					}
				?>
        </section>

        <section id="imagemind">
            <div>
                <img src="_imagens/logotrans.png" type="image/png">
            </div>
        </section>

    </main>

    <footer id="rodape">
        <p>Todos os direitos reservados&copy; 2022</p>
        <p>Ghost Tóxic Team &trade;</p>
    </footer>
</body>

</html>