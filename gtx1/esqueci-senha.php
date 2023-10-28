<!DOCTYPE html>
<html lang="pt-br">

	<head>
		<meta charset="UTF-8"/>
		<link rel="stylesheet" href="_css/estilogtx.css"/>
		<link href="logogtx.png" rel="icon" type="image/png" />
		<title>Ghost Tóxic Team</title>
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

			<h1 id="maintitulo"> Recuperar senha </h1>

			<div class="formesquecisenha">
				<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<div>
						<label for="nick">Nick:</label>
						<input type="text" name="nick" pattern="[A-Za-zÀ-ÿ]+(\s[A-Za-zÀ-ÿ]+)*" maxlength="30" title="Informe seu nick origin" size="20" required>
					</div>
					<div>
						<label for="novasenha">Nova senha: </label>
						<input type="text" name="novasenha" title="Digite a sua senha. Somente letras e numeros." maxlength="10" pattern="[0-9A-Za-z]+" size="20" required>
					</div>
						<input type="submit" value="Solicitar alteração">
				</form>
					<?php

						// Criar a conexão com o PostgreSQL usando pdo 
						require __DIR__."/conexao.php";

						if ($_SERVER["REQUEST_METHOD"] == "POST") {
							
								$nick = $_POST['nick'];
								$novasenha = $_POST['novasenha'];
								$dataatual = date("Y-m-d");

								try {

								// Prepara a consulta SQL
								$sql = "SELECT id 
										FROM pessoa 
										WHERE nick = '$nick'";
								$consulta1 = $conexao->prepare($sql);
							
								// Executa a consulta
								$consulta1->execute();

								if ($consulta1->rowCount() > 0) {

								$registro = $consulta1->fetch(PDO::FETCH_ASSOC);
								$idprovisorio = $registro['id'];

								// Prepara a consulta SQL de atualização
								$sql = "INSERT INTO recuperasenha VALUES ('$idprovisorio','$nick','$novasenha',1,'$dataatual')";
								$consulta2 = $conexao->prepare($sql);

								// Executa a consulta de atualização
								$consulta2->execute();
								echo "<div class=\"formrecrut\">
										<h3>Solicitação realizada com sucesso!</h3>
									</div>";
								} else {
									echo "<div class=\"formrecrut\">
											<h3>Usuário não encontrado.</h3>
										</div>";
								}
								} catch (PDOException $e) {
									// Erro na conexão com o banco de dados
									echo 'Erro na conexão com o banco de dados: ' . $e->getMessage();
								}
						}
					?>
			</div>
		</main>

		<footer id="rodape">
			<p>Todos os direitos reservados&copy; 2022</p> 
			<p>Ghost Tóxic Team &trade;</p>
		</footer>
	</body>
</html>