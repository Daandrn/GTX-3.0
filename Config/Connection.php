<?php 

namespace Config;

use Exception;
use PDO;

function connection(): PDO|string
{
    $drive    = "pgsql";
    $host     = "localhost";
    $dataBase = "GTX3";
    $user     = "postgres";
    $password = "Danillo@126";
    
    try {
        $conn = new PDO("$drive:host=$host;dbname=$dataBase", $user, $password);

        return $conn;
    } catch (\Throwable $error){
        throw new Exception("Erro ao conectar ao banco de dados: ".$error->getMessage());
    }
}
