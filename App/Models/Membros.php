<?php declare(strict_types=1);

namespace App\Models;

use App\Interfaces\ModelInterface;
require __DIR__.'/../Interfaces/ModelInterface.php';
use PDO;
use stdClass;

use function Config\connection;
require __DIR__ . "/../../Config/Connection.php";

class Membros implements ModelInterface
{
    /**
     * @param object $params Deve ter o seguinte padrão: ['id', '=', 5, 'ORDER...DESC'] ou ['status', 'in', '(1,2,3)', 'ORDER...DESC']
     */
    public function select(array $params = null): array
    {
        if (!$params) {
            $consulta = connection()->prepare("SELECT * FROM membros");
        }

        if ($params) {
            $consulta = connection()->prepare("SELECT * FROM membros WHERE ".$params[0]." ".$params[1]." ".$params[2]." ".$params[3]);
        }

        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

        return $resultado;
    }

    /**
     * @param object $params Recomenda-se receber um dto.
     */
    public function insert(object $params): bool
    {
        $consulta = connection()->prepare("INSERT INTO (nome, nick, plataforma, status_solicit, senha) 
                                                VALUES (:nome, :nick, :plataforma, :status_solicit, :senha)");
        $consulta->bindParam(':nome', $params[0], PDO::PARAM_STR);
        $consulta->bindParam(':nick', $params[1], PDO::PARAM_STR);
        $consulta->bindParam(':plataforma', $params[2], PDO::PARAM_INT);
        $consulta->bindParam(':status_solicit', $params[3], PDO::PARAM_INT);
        $consulta->bindParam(':senha', $params[4], PDO::PARAM_INT);
        
        return $consulta->execute();
    }

    public function update(string $id, object $data): bool
    {
        $dataComApenasUmCampo = true;
        if ($dataComApenasUmCampo) {
        }

        $dataComTodosOsCampo = false;
        if ($dataComTodosOsCampo) {
        }

        return true;
    }

    public function delete(string $id): bool
    {
        $consulta = connection()->prepare("DELETE FROM membros WHERE id = :id");
        $consulta->bindParam(':id', $idPessoa, PDO::PARAM_INT);

        return $consulta->execute();
    }


}

$model = new Membros;
