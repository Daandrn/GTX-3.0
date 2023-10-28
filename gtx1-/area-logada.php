<?php

	header('Cache-Control: must-revalidate');
	session_start();

	if (!isset($_SESSION['nick']) || empty($_SESSION['nick'])) {
		// Redireciona para a página de login ou exibe uma msg de erro
		session_destroy();
		header('Location: index.php');
		exit();
	}

?>

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
		</header>	

		<main id="interface">
			
			<h1 id="maintitulo"> Área logada </h1>
			<?php

				// Criar a conexão com o PostgreSQL usando pdo 
				require_once __DIR__."/conexao.php";

				try {
											
					// consulta sql para verificar se o usuário logado está na lista de membros
					$consultaid = $conexao->query("SELECT pessoa.id, pessoa.nome, pessoa.nick, status_solicit, canalstream.nickstream as nickstream, canalstream.link_canal as linkcanal
													FROM pessoa 
													inner join canalstream on pessoa.id = canalstream.id
													where pessoa.nick is not null and pessoa.status_solicit in (1,4)");

					// salva o id e nome do login com base na lista de membros
					while ($idconsulta = $consultaid->fetch(PDO::FETCH_ASSOC)) {
						if ($_SESSION['nick'] == $idconsulta['nick']) {
							$idlogin = $idconsulta['id'];
							$nickorigin = $idconsulta['nick'];
							$nomelogin = $idconsulta['nome'];
							$adm = $idconsulta['status_solicit'];
							$nickstreamatual = $idconsulta['nickstream'];
							$linkcanalatual = $idconsulta['linkcanal'];																		  
						} 
					}
				} catch (PDOException $e) {
					echo 'Erro na conexão com o banco de dados: ' . $e->getMessage();
				}
			?>
			<h2 id="boasvindas">Seja bem vindo, <?php echo $nomelogin?>!</h2> 
			<section id="admusuario">

					<div id="formcanalstream">
						<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<div>
								<label for="nicknickatual">Nick stream:</label>
								<input type="text" name="nickatual" value="<?php echo $nickstreamatual?>" pattern="[A-Za-z0-9]*" maxlength="20" title="Informe seu nick da plataforma de stream" required>
							</div>
							<div>
								<label for="linkatual">link canal: </label>
								<input type="text" name="linkatual" value="<?php echo $linkcanalatual ?>" maxleght="70" title="Informe o link reduzido do seu canal." required>
							</div>
							<div>
								<label for="plataformaatual">Plataforma: </label>
								<select name="plataformaatual" required>
								<option value=""></option>

								<?php

									try{

										$consulta = $conexao->query("SELECT id, descricao
																	FROM plataformastream");

										// Loop para criar as opções do select
										foreach ($consulta as $plataforma) {
											echo '<option value="' . $plataforma['id'] . '"';

												// consultar qual a plataforma do id logado
												$consulta2 = $conexao->query("SELECT canalstream.id, canalstream.plataforma as idcanalplat, plataformastream.id as idplataforma, plataformastream.descricao
												FROM plataformastream
												inner join canalstream on plataformastream.id = canalstream.plataforma where canalstream.id = $idlogin");
												$retornoconsulta2 = $consulta2->fetch(PDO::FETCH_ASSOC);
												
												// seleciona o item na tela caso a plataforma do usuário logado seja listada.
												if (!isset($retornoconsulta2['idcanalplat'])) {
													echo '';
												}
												elseif ($retornoconsulta2['idcanalplat'] == $plataforma['id']){
													echo "selected";
												}

											echo '>';
											echo $plataforma['descricao'] . '</option>';
										}
									} catch (PDOException $e) {
										echo 'Erro na conexão com o banco de dados: ' . $e->getMessage();
									}
									
								?>
								
								</select>
							</div>
							<input id="formcanalstreaminput" name="formstream" type="submit" value="Salvar">
						</form>				  
					</div>
					<div id="perfilesenha">
						<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
								<div id="inputnicksenha">
									<label for="originatual">Nick/origin:</label>
									<input type="text" name="originatual" value="<?php echo $nickorigin;?>" pattern="[A-Za-z0-9]+(\s[A-Za-z0-9]+)*" maxlength="20" title="Informe seu nick/origin." required>
								</div>
								<input id="perfilesenhainput" name="alteranick" type="submit" value="Alterar nick">
								
								<div id="inputnicksenha">
									<label for="novasenha">Nova senha: </label>
									<input type="text" name="novasenha" value="" maxleght="10" pattern="[0-9A-Za-z]+">
								</div>	
								<input id="perfilesenhainput" name="alterasenha" type="submit" value="Alterar senha">
								
						</form>				
					</div>
					
					<?php 

						try{

							if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['formstream'])) {

								$novonickstream = $_POST['nickatual'];
								$novolink = $_POST['linkatual'];
								$novaplataforma = $_POST['plataformaatual'];

									$consulta = $conexao->prepare("UPDATE canalstream 
																SET	plataforma = $novaplataforma, link_canal = '$novolink', nickstream = '$novonickstream'
																WHERE id = $idlogin");
									$consulta->execute();
								header('location: area-logada.php');
							}

						} catch (PDOException $e) {
							echo 'Erro na conexão com o banco de dados: ' . $e->getMessage();
						}
					?>
					<?php
						try {

							if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['alteranick'])) {

								$novaorigin = $_POST['originatual'];
								$novasenha = $_POST['novasenha'];
		
									$consultasenha = $conexao->prepare("UPDATE pessoa 
																	SET nick = '$novaorigin'
																	where id = $idlogin");
									$consultasenha->execute();

								// necessário apenas pelo fato da validação do login ser feita pelo usuário,m mas pode ser alterado para o ID - teria que mudar todas as verificações que sao feitas pelo usuário
								echo '<section id="sectionalteranick">
										<div id="divalteranick">
											<h3>Nick alterado com sucesso. Faça login novamente!</h3>
											<button onclick="window.location.href=\'sair.php\'">Sair</button>	 
										</div>
									 </section>';

							} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['alterasenha'])) {


								$novaorigin = $_POST['originatual'];
								$novasenha = $_POST['novasenha'];
		
									$consultasenha = $conexao->prepare("UPDATE pessoa 
																	SET senha = '$novasenha'
																	where id = $idlogin");
									$consultasenha->execute();
								header('location: area-logada.php');

							}

						} catch (PDOException $e) {
							echo 'Erro na conexão com o banco de dados: '. $e->getMessage();
						}
					?>

			</section>
			<section id="admmembros">
			    <?php

					try {

						// Executar consulta SQL para selecionar registros
						$consulta = $conexao->query("SELECT DISTINCT pessoa.id, pessoa.nome, pessoa.nick as nick, pessoa.plataforma, pessoa.status_solicit, statusmembro.descricao 
													FROM pessoa 
													inner join statusmembro on pessoa.status_solicit = statusmembro.status_solicit 
													where (pessoa.nick is not null and pessoa.status_solicit in (1,4))
													order by pessoa.status_solicit desc");

						// Verificar se há registros retornados
						if ($consulta->rowCount() > 0) {
							// Exibir os registros em uma tabela
							echo '<table class="solicitacaorecrutamento"><caption>Membros</caption>';
							echo '<tr><th>ID</th><th>Nome</th><th>Nick</th><th>Plataforma</th><th>Status Membro</th><th>Ação</th></tr>';
							
							// Iterar sobre os registros retornados
							while ($registro = $consulta->fetch(PDO::FETCH_ASSOC)) {
								echo '<tr>';
								echo '<td>' . $registro['id'] . ' </form></td> ';
								echo '<td style="width: 200px;"> ' . $registro['nome'] . ' </td> ';
								echo '<td style="width: 110px;"> ' . $registro['nick'] . ' </td> ';
								echo '<td> ' . $registro['plataforma'] . ' </td> ';
								echo '<td> ' . $registro['status_solicit'] .' - '. $registro['descricao'] . ' </td> ';
								
								if ($adm === 4){
								
									echo '<td id="formtd">
												<form id="form2'.$registro['id'].'" method="POST" action="admmembros.php">
													<input type="hidden" name="id" value="'. $registro['id'] .'">
													<select name="acao" required>
														<option value="">Selecione</option>
														<option value="1">Membro</option>
														<option value="4">Administrador</option>
														<option value="3">Expulso</option>
													</select>
													<input type="submit" value="salvar" form="form2'.$registro['id'].'">
												</form>
											</td>';
								} else {
									echo '<td id="formtd">
											<input type="submit" value="Xingar">
											<input type="submit" value="Elogiar">
										 </td>';
								}
								echo '</tr>';
							}
							
							echo '</table>';
						} else {
							echo "<table class=\"solicitacaorecrutamento\" style=\"width: 480px;\">
									<caption>Membros</caption>
									<tr><th>ID</th><th>Nome</th><th>Nick</th><th>Plataforma</th><th>Status solicitação</th><th>Ação</th></tr>
									<tr><td colspan=\"9\" style=\"width: 400px;\">Nenhum Membro!</td></tr>	
								 </table>";
						}
					} catch (PDOException $e) {
						echo 'Erro na conexão com o banco de dados: ' . $e->getMessage();
					}
				?>
			</section>
			<section id="admrecrut">
				<?php

					if ($adm === 4){ 

						try {

							// Executar consulta SQL para selecionar registros
							$consulta = $conexao->query("SELECT DISTINCT pessoa.id, pessoa.nome, pessoa.nick, pessoa.plataforma, pessoa.status_solicit, statusmembro.descricao 
														FROM pessoa 
														inner join statusmembro on pessoa.status_solicit =  statusmembro.status_solicit 
														where (pessoa.nick is not null and pessoa.status_solicit = 0)");

							// Verificar se há registros retornados
							if ($consulta->rowCount() > 0) {
								// Exibir os registros em uma tabela
								echo '<table class="solicitacaorecrutamento"><caption>Solicitações de recrutamento</caption>';
								echo '<tr><th>ID</th><th>Nome</th><th>Nick</th><th>Plataforma</th><th>Status solicitação</th><th>Ação</th></tr>';
								
								// Iterar sobre os registros retornados
								while ($registro = $consulta->fetch(PDO::FETCH_ASSOC)) {
									echo '<tr>';
									echo '<td>' . $registro['id'] . ' </form></td> ';
									echo '<td style="width: 200px;"> ' . $registro['nome'] . ' </td> ';
									echo '<td style="width: 110px;"> ' . $registro['nick'] . ' </td> ';
									echo '<td> ' . $registro['plataforma'] . ' </td> ';
									echo '<td> ' . $registro['status_solicit'] .' - '. $registro['descricao'] . ' </td> ';
									echo '<td id="formtd">
											<form id="form1'.$registro['id'].'" method="POST" action="admmembros.php">
												<input type="hidden" name="id" value="'. $registro['id'] .'">
												<select name="acao">
													<option value="1">Aceitar</option>
													<option value="2">Rejeitar</option>
												</select>
												<input type="submit" value="salvar" form="form1'.$registro['id'].'">
											</form>
										</td>';
									echo '</tr>';
								}
								
								echo '</table>';
							} else {
								echo "<table class=\"solicitacaorecrutamento\" style=\"width: 480px;\">
										<caption>Solicitações de recrutamento</caption>
										<tr><th>ID</th><th>Nome</th><th>Nick</th><th>Plataforma</th><th>Status solicitação</th><th>Ação</th></tr>
										<tr><td colspan=\"9\" style=\"width: 400px;\">Nenhuma solicitação pendente!</td></tr>	
									</table>";
							}
						} catch (PDOException $e) {
							echo 'Erro na conexão com o banco de dados: ' . $e->getMessage();
						}
					}	
				?>
			</section>
			<section id="admoutros">
			    <?php
					if ($adm === 4){
						try {

							// Executar consulta SQL para selecionar registros
							$consulta = $conexao->query("SELECT DISTINCT pessoa.id, pessoa.nome, pessoa.nick, pessoa.plataforma, pessoa.status_solicit, statusmembro.descricao 
														FROM pessoa 
														inner join statusmembro on pessoa.status_solicit =  statusmembro.status_solicit 
														where (pessoa.nick is not null and pessoa.status_solicit in (2,3))");

							// Verificar se há registros retornados
							if ($consulta->rowCount() > 0) {
								// Exibir os registros em uma tabela
								echo '<table class="solicitacaorecrutamento"><caption>Rejeitados e Expulsos</caption>';
								echo '<tr><th>ID</th><th>Nome</th><th>Nick</th><th>Plataforma</th><th>Status</th><th>Ação</th></tr>';
								
								// Iterar sobre os registros retornados
								while ($registro = $consulta->fetch(PDO::FETCH_ASSOC)) {
									echo '<tr>';
									echo '<td>' . $registro['id'] . ' </form></td> ';
									echo '<td style="width: 200px;"> ' . $registro['nome'] . ' </td> ';
									echo '<td style="width: 110px;"> ' . $registro['nick'] . ' </td> ';
									echo '<td> ' . $registro['plataforma'] . ' </td> ';
									echo '<td> ' . $registro['status_solicit'] .' - '. $registro['descricao'] . ' </td> ';
									echo '<td id="formtd">
											<form method="POST" id="form3'.$registro['id'].'" action="admmembros.php">
												<input type="hidden" name="id" value="'. $registro['id'] .'">
												<select name="acao" required>
													<option value="">Selecione</option>
													<option value="1">Recrutar</option>
												</select>
												<input type="submit" form="form3'.$registro['id'].'" value="salvar">
											</form>
											<form method="POST" id="form4'.$registro['id'].'" action="admmembros.php">
												<input type="hidden" name="excluir" value="10">
												<input type="hidden" name="id" value="'. $registro['id'] .'">
												<input type="submit" form="form4'.$registro['id'].'" value="Excluir">
											</form>
										</td>';
									echo '</tr>';
								}
								
								echo '</table>';
							} else {
								echo "<table class=\"solicitacaorecrutamento\" style=\"width: 480px;\">
										<caption>Rejeitados e Expulsos</caption>
										<tr><th>ID</th><th>Nome</th><th>Nick</th><th>Plataforma</th><th>Status solicitação</th><th>Ação</th></tr>
										<tr><td colspan=\"9\" style=\"width: 400px;\">Nenhum registro!</td></tr>	
									</table>";
							}
						} catch (PDOException $e) {
							echo 'Erro na conexão com o banco de dados: ' . $e->getMessage();
						}
					}
				?>
			</section>
			<section id="admrecuperasenha">
			    <?php
					if ($adm === 4){
						try {

							// Executar consulta SQL para selecionar registros
							$consulta = $conexao->query("SELECT pessoa.id, pessoa.nome, pessoa.nick, pessoa.plataforma, pessoa.status_solicit, statusmembro.descricao, recuperasenha.data_solicit 
														FROM pessoa 
														inner join statusmembro on statusmembro.status_solicit = pessoa.status_solicit 
														inner join recuperasenha on pessoa.id = recuperasenha.id 
														where (pessoa.nick is not null and recuperasenha.solicit_senha = 1 and pessoa.status_solicit in (4,1)) 
														order by recuperasenha.data_solicit asc");

							// Verificar se há registros retornados
							if ($consulta->rowCount() > 0) {
								// Exibir os registros em uma tabela
								echo '<table class="solicitacaorecrutamento"><caption>Solicitações de nova senha</caption>';
								echo '<tr><th>ID</th><th>Nome</th><th>Nick</th><th>Data solic.</th><th>Status</th><th>Ação</th></tr>';
								
								// Iterar sobre os registros retornados
								while ($registro = $consulta->fetch(PDO::FETCH_ASSOC)) {
									echo '<tr>';
									echo '<td>' . $registro['id'] . ' </form></td> ';
									echo '<td style="width: 200px;"> ' . $registro['nome'] . ' </td> ';
									echo '<td style="width: 110px;"> ' . $registro['nick'] . ' </td> ';
									echo '<td> ' . $registro['data_solicit'] . ' </td> ';
									echo '<td> ' . $registro['status_solicit'] .' - '. $registro['descricao'] . ' </td> ';
									echo '<td id="formtd">
											<form method="POST" id="form5'.$registro['id'].'" action="admmembros.php">
												<input type="hidden" name="idaceitasenha" value="'. $registro['id'] .'">
												<input type="hidden" name="aceitasenha" value="21">
												<input type="hidden" name="datasolic" value="'.$registro['data_solicit'].'">
												<input type="submit" form="form5'.$registro['id'].'" value="Aceitar">
											</form>
											<form method="POST" id="form6'.$registro['id'].'" action="admmembros.php">
												<input type="hidden" name="excluisenha" value="11">
												<input type="hidden" name="idexcluisenha" value="'. $registro['id'] .'">
												<input type="submit" form="form6'.$registro['id'].'" value="Excluir">
											</form>
										</td>';
									echo '</tr>';
								}
								
								echo '</table>';
							} else {
								echo "<table class=\"solicitacaorecrutamento\" style=\"width: 480px;\">
										<caption>Solicitações de nova senha</caption>
										<tr><th>ID</th><th>Nome</th><th>Nick</th><th>Plataforma</th><th>Status solicitação</th><th>Ação</th></tr>
										<tr><td colspan=\"9\" style=\"width: 400px;\">Nenhum registro!</td></tr>	
									</table>";
							}
						} catch (PDOException $e) {
							echo 'Erro na conexão com o banco de dados: ' . $e->getMessage();
						}
					}
				?>
			</section>
			<div id="sairbotao">				
				<form action="sair.php"> 
					<input type="submit" value="Sair">
				</form>
			</div>
				
		</main>

		<footer id="rodape">
			<p>Todos os direitos reservados&copy; 2022</p> 
			<p>Ghost Tóxic Team &trade;</p>
		</footer>
	</body>
</html>