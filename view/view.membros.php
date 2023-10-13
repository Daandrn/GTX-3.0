<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GTX</title>
    <link rel="stylesheet" href="/css/stylegtx.css">
    <link rel="shortcut icon" href="/css/imagens/logotrans.png" type="image/x-png">
</head>
<body>
    <header>
        <div class="cabecalho">
            <h1>GHOST TÓXIC TEAM</h1>
        </div>
        <div class="navegador">
            <nav>
                <ul>
                    <li><a href="/control/control.inicio.php" >Inicio</a></li>
                    <li><a href="/control/control.arealogada.php">Área logada</a></li>
                    <li><a href="/control/control.salavideos.php">Sala de videos</a></li>
                    <li><a href="/control/control.membros.php">Membros</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="principal">
        <div>
            <table>
                <caption>MEMBROS</caption>
                <th style="width: 218px;">Nome</th><th style="width: 143px;">Origin</th><th style="width: 108px;">Cargo</th><th style="width: 143px;">Nick stream</th><th style="width: 78px;">plataforma</th>
                <?php while ($resultado = $consulta->fetch(PDO::FETCH_ASSOC)):?>
                <tr style="height: 30px;">
                    <td><?php echo $resultado['nome'];?></td>
                    <td><?php echo $resultado['nick'];?></td>
                    <td><?php echo $resultado['cargo'];?></td>
                    <td><a href="<?php echo $resultado['link_canal'];?>"><?php echo $resultado['nickstream'];?></a></td>
                    <td><?php echo $resultado['plataforma'];?></td>
                </tr>
                <?php endwhile ?>
            </table>
        </div>
    </main>
    <footer>
        <p>Ghost tóxic team&trade;</p>
        <p>Todos os direitos reservados&copy;</p>
        <p>2023</p>
    </footer>
</body>
</html>