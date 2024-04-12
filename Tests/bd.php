<form method="post">
<textarea name="query" id="query" cols="90" rows="10" required></textarea>
<input type="submit" name="Processar" value="Processar">
</form>

<textarea name="result" id="result" cols="90" rows="20">
<?php

use function Config\connection;

require_once __DIR__ . "/../configuracao/connection.php";

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['Processar'] === 'Processar') {
        $sql = $_POST['query'];
        $consulta = connection()->query($sql);
        $result = $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $erro) {
    echo "Erro no banco de dados: " . $erro->getMessage();
}
?>
<?php 
    if (isset($result)) { 
        var_dump($result); 
    } 
?>
</textarea>
