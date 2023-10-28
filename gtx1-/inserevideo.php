<?php

try {
    // Conexão com o banco de dados usando PDO
    $conexao = new PDO("pgsql:host='localhost';dbname='postgres'", 'postgres', '123');
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Leitura do arquivo de vídeo e conversão para dados binários
    $videoPath = "introgtx.mp4";
    $dadosVideo = file_get_contents($videoPath);

    // Comando SQL para inserir o vídeo na tabela
    $comandoSQL = "INSERT INTO videos (idvideo, video, data_video) 
                    VALUES (1, :video, '2023-07-29')";

    // Preparação da consulta sql
    $consulta = $conexao->prepare($comandoSQL);

    // Executa a consulta passando os dados binários do vídeo como parâmetro
    $consulta->bindParam(':video', $dadosVideo, PDO::PARAM_LOB);
    $consulta->execute();

    echo "Vídeo inserido com sucesso na tabela.";

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}

?>

