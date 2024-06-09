<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GTX</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="shortcut icon" href="/Public/Css/imagens/logotrans.png" type="image/x-png">
</head>

<body>
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
                </ul>
            </nav>
        </div>
    </header>