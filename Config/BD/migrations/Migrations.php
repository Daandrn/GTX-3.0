<?php 

namespace Config\BD\Migrations;

use Config\DataBase;
use Exception;

class Migrations
{
    public function up()
    {
        //
    }

    public function down()
    {
        //
    }

    protected function execSql($sql)
    {
        try {
            $consulta = DataBase::conn()->prepare($sql);
            $consulta->execute();
        } catch (\Throwable $error) {
            throw new Exception("Erro durante execução sql: ". $error->getMessage());
        }
    }

    public static function run()
    {
        $migrations = new Migrations;
        $migrations->up();
    }

    public static function revert()
    {
        $migrations = new Migrations;
        $migrations->down();
    }
}


