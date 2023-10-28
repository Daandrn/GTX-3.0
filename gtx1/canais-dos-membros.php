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

            <h1 id="maintitulo"1> Canais dos membros </h1>

            <?php

            // chama o arquivo que Cria a conexão com o PostgreSQL usando PDO
            require_once __DIR__."/conexao.php";

            try {

                // Executar consulta SQL para selecionar registros
                $consulta = $conexao->query("SELECT DISTINCT canalstream.id as id, plataformastream.descricao as plataforma, link_canal, nickstream 
                                            FROM canalstream
                                            inner join plataformastream on plataformastream.id = canalstream.plataforma
                                            inner join pessoa on canalstream.id = pessoa.id
                                            where (nickstream is not null and link_canal is not null and pessoa.status_solicit in (1,4))
                                            order by nickstream");

                // Verificar se há registros retornados
                if ($consulta->rowCount() > 0) {
                    // Exibir os registros em uma tabela
                    echo '<div id="divmembros"><table class="membro-lista">';
                    echo '<tr><th>Plataforma</th><th>Nick</th></tr>';
                    
                    // Iterar sobre os registros retornados
                    while ($registro = $consulta->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr>';
                        echo '<td style="min-width: 200px;"> ' . $registro['plataforma'] . ' </td>';
                        echo '<td style="min-width: 120px;"><a title="Clique para redirecionar!" href="' . $registro['link_canal'] . '" target="_blank">' . $registro['nickstream'] . '</a> </td>';
                        echo '</tr>';
                    }
                    
                    echo '</table></div>';
                } else {
                    echo '<div class="semRegistro">Nenhum canal encontrado.</div>';
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