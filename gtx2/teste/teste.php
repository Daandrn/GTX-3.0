<?php 

function formatLink($string) {

    $string = str_ireplace(["www.", "https://", "http://"], "", $string);

    return $string;
}

$texto = 'HTTPS://www.twitch.com';

$texto = formatLink($texto);

echo $texto . PHP_EOL;

$texto = formatLink($texto);

echo $texto . PHP_EOL;

$texto = formatLink($texto);

echo $texto . PHP_EOL;

?>