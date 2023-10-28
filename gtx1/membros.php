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
            <h1 id="maintitulo"> Membros </h1>
            <?php
            
            // chama o arquivo que Cria a conexão com o PostgreSQL usando PDO
            require_once __DIR__."/conexao.php";

            try {                

                // Executar consulta SQL para selecionar registros
                $consulta = $conexao->query("SELECT DISTINCT id, nome, nick, plataforma, pessoa.status_solicit, statusmembro.descricao as membro
                                            FROM pessoa 
                                            join statusmembro on pessoa.status_solicit = statusmembro.status_solicit
                                            where nick is not null and pessoa.status_solicit in (1,4)
                                            order by pessoa.status_solicit desc");

                // Verificar se há registros retornados
                if ($consulta->rowCount() > 0) {
                    // Exibir os registros em uma tabela
                    echo '<div id="divmembros"><table class="membro-lista">';
                    echo '<tr><th>Nome</th><th>Nick</th><th>Plataforma</th><th>Membro</th></tr>';
                    
                    // Iterar sobre os registros retornados - Enquanto $registro receber registros do fetch pdo
                    while ($registro = $consulta->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr>';
                        echo '<td style="width: 200px;"> ' . $registro['nome'] . ' </td>';
                        echo '<td style="width: 110px;"> ' . $registro['nick'] . ' </td>';
                        echo '<td> ' . $registro['plataforma'] . ' </td>';
                        echo '<td> ' . $registro['membro'] . ' </td>';
                        echo '</tr>';
                    }
                    
                    echo '</table></div>';
                } else {
                    echo '<div class="semRegistro">Nenhum membro encontrado.</div>';
                }
            } catch (PDOException $e) {
                echo 'Erro na conexão com o banco de dados: ' . $e->getMessage();
            }
            ?>
        </main>

        <footer id="rodape">
		    <p>Todos os direitos reservados&copy; 2022</p> 
		    <p>Ghost Tóxic Team &trade;</p>
		</footer>
	 
    </body>
</html>