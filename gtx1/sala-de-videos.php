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
        	<h1 id="maintitulo"> Sala de videos </h1>
			<section id="salavideo">
				<div>
					<video autoplay loop src="_imagens/introgtx.mp4" type="video/mp4"></video> 
				</div>
				<?php
				
				/*	Não estamos prontos para essa funcionalidade ainda.
				  
						try {
						$conexao = new PDO("pgsql:host=localhost;dbname=postgres", 'postgres', 123);
						$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

						$sql = "SELECT DISTINCT idvideo, video, data_video 
								FROM videos
								order by data_video desc";
						$consulta = $conexao->prepare($sql);
						$consulta->execute();

						// Define o tipo de conteúdo como vídeo MP4
						header("Content-type: video/mp4");

						if ($consulta->rowCount() > 10) {
							while ($registro = $consulta->fetch(PDO::FETCH_ASSOC)) {
								// Define o tipo de conteúdo como vídeo MP4
								header("Content-type: video/mp4");

								echo '<div>
										<video controls src="data:video/mp4;base64,' . base64_encode($registro['video']) . '"></video>
									</div>';
							}
						} else {
							echo "<h2>Nenhum registro encontrado!</h2>";
						}
					} catch (PDOException $e) {
							// Erro na conexão com o banco de dados
							echo 'Erro na conexão com o banco de dados: ' . $e->getMessage();
						}

				*/?>
			</section>
		</main>

		<footer id="rodape">
			<p>Todos os direitos reservados&copy; 2022</p> 
			<p>Ghost Tóxic Team &trade;</p>
		</footer>

	</body>
</html>