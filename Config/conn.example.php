<?php

namespace Config;

use Exception;
use PDO;

require_once __DIR__ . '/../Vendor/autoload.php';

class DBexample
{
    public static function conn(): PDO|string
    {
        $drive    = "pgsql";
        $host     = "localhost";
        $dataBase = "GTX3";
        $user     = "postgres";
        $password = "";
        
        try {
            $conn = new PDO("$drive:host=$host;dbname=$dataBase", $user, $password);
    
            return $conn;
        } catch (\Throwable $error) {
            throw new Exception("Erro ao conectar ao banco de dados: " . $error->getMessage());
        }
    }
}
