<?php 

require __DIR__ . "/../configuracao/conexao.php";

$consulta = $conexao->prepare("SELECT pessoa.nome as nome, pessoa.nick as nick, statusmembro.descricao as cargo, canalstream.nickstream as nickstream, plataformastream.descricao as plataforma, canalstream.link_canal  
                                FROM pessoa 
                                LEFT JOIN canalstream ON pessoa.id = canalstream.id
                                LEFT JOIN statusmembro ON pessoa.status_solicit = statusmembro.status_solicit
                                LEFT JOIN plataformastream ON canalstream.plataforma = plataformastream.id
                                WHERE pessoa.status_solicit in (1, 4)
                                ORDER BY pessoa.status_solicit DESC");
$consulta->execute();

?>