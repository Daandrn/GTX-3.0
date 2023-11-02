<?php 

$bancoDeDados = "pgsql";
//$host = "localhost";
$baseDeDados = "GTX2";
//$usuario = "postgres";
//$senha = "123";

try {
    
    $conexao = new PDO("$bancoDeDados:host=$host;dbname=$baseDeDados", $usuario, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (\Throwable $erro){
    echo "Erro no banco de dados: ". $erro->getMessage();
}

?>