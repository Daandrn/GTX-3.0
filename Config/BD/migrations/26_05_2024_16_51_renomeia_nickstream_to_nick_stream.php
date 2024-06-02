<?php 

namespace Config\BD\Migrations;

new class extends Migrations
{
    public function up()
    {
        $sql = 'ALTER TABLE canalstream RENAME COLUMN nickstream TO nick_stream';

        $this->execSql($sql);
    }

    public function down()
    {
        $sql = 'ALTER TABLE canalstream RENAME COLUMN nick_stream TO nickstream';

        $this->execSql($sql);
    }
};

Migrations::run();
