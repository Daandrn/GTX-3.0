<?php 

namespace Config;

use PDO;
use PDOException;

function connection(): PDO|string
{
    $drive    = "pgsql";
    $host     = "localhost";
    $dataBase = "GTX3";
    $user     = "postgres";
    $password = "123";
    
    try {
        $conn = new PDO("$drive:host=$host;dbname=$dataBase", $user, $password);

        return $conn;
    } catch (PDOException $error){
        return "Erro ao conectar ao banco de dados: ". $error->getMessage();
    }
}