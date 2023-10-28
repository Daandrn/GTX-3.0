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
			<h1 id="maintitulo">Solicitar recrutamento</h1>
			
			<div class="formrecrut">
				<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<div>
						<label for="nome">Nome:</label>
						<input type="text" name="nome" pattern="[A-Za-zÀ-ÿ]+(\s[A-Za-zÀ-ÿ]+)*" maxlength="30" title="Informe seu nome apenas com letras." size="24" required>
					</div>
					<div>
						<label for="plataforma" >Plataforma:</label>
						<select name="plataforma" required>
							<option value=""></option>
							<option value="PC">PC</option>
							<option value="Xbox Séries">Xbox Séries</option>
							<option value="Ps5">Ps5</option>
						</select>
					</div>
					<div>
						<label for="origin">Nickname: </label>
						<input type="text" name="origin" maxlength="20" pattern="[A-Za-z0-9]+(\s[A-Za-z0-9]+)*" title="Digite a sua origin" required>
					</div>
						<input type="submit" value="Enviar">
				</form>
			</div>
			<?php

				if ($_SERVER["REQUEST_METHOD"] == "POST") {
					
					try {  

						$nome = $_POST['nome'];
						$plat = $_POST['plataforma'];
						$origin = $_POST['origin'];

							require_once __DIR__."/conexao.php";
							
						// Preparar a consulta de inserção
						$sql = "INSERT INTO pessoa (nome, nick, plataforma, id, status_solicit, senha) VALUES (:nome, :origin, :plat, :id, :status_solicit, :senha)";
						$consulta = $conexao->prepare($sql);
								
						// Consulta para obter o último ID da tabela
						$sql = "SELECT MAX(id) as max_id FROM pessoa";
						$consultaid = $conexao->query($sql);
						$resultado = $consultaid->fetch(PDO::FETCH_ASSOC);
						$ultimoId = $resultado['max_id'];

						// Gerar o próximo ID
						$novoId = $ultimoId + 1;

						// Valores a serem inseridos
						$valores = [$nome, $origin, $plat, $novoId, $status_solicit = 0, $senha = 123456];

						// Executar a consulta com os valores fornecidos
						$consulta->execute($valores);

						// Criar o registro do canal do membro ao receber a solicitação de recrutamento
						$sql = "INSERT INTO canalstream (id, plataforma, link_canal, nickstream)
								VALUES (:id2,null,null,null)";
							
						$consulta2 = $conexao->prepare($sql);
						$consulta2->execute(array(':id2' => $novoId));
						
						echo '<div class="resprecrut"> 
								<h2>Recebemos sua solicitação!</h2>
								<h3>Nome: "', $nome,'". </h3>
								<h3>Nick: "', $origin,'". <h3>
							</div>';
					}   catch (PDOException $e) {
					if ($e->getCode() == "23505") {
						echo ("<div class=\"resprecrut\">
								<h2>Erro: Já existe um jogador com o mesmo nick.</h2>
							</div>");
						} else {
						echo "<h2>Erro ao inserir o registro: " . $e->getMessage(). "</h2>";
						}
					}
				}
            ?>	
		</main>
			
		<footer id="rodape">
			<p>Todos os direitos reservados&copy; 2022</p> 
			<p>Ghost Tóxic Team &trade;</p>
		</footer>
	</body>
</html>