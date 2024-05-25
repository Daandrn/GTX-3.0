<?php

namespace Vendor\Model;

use Config\DataBase;
use PDO;
use Vendor\Interfaces\ModelInterface;

require_once __DIR__ . '/../autoload.php';

class Model implements ModelInterface
{
    protected string $tableName;
    protected array $fillable;

    public function __construct(string $tableName, array $fillable)
    {
        $this->tableName = $tableName;
        $this->fillable = $fillable;
    }

    /**
     * @param array $fields Deve ter o seguinte padrão: ['id', 'nome', 5, '*'] ou ['id as codigo', 'nome'] ou ['tabela.descricao']
     * @param array $join Deve ter o seguinte padrão: ['nome_tabela', 'campo_referencia', 'tipo_join', 'alias_campo_referencia'] ou [['nome_tabela', 'campo_referencia', 'tipo_join', 'alias_campo_referencia'], ['nome_tabela', 'campo_referencia', 'tipo_join', 'alias_campo_referencia']]
     * @param array $where Deve ter o seguinte padrão: ['id', '=', 5, 'ORDER...DESC'] ou ['status', 'in', '(1,2,3)', 'ORDER...DESC']
     */
    public function select(array $fields = ['*'], array $join = null, array $where = null): array
    {
        $fields = implode(',', $fields);
        $fields = rtrim($fields, ',');

        if ($join) {
            if (!is_array($join[0])) {
                $join = $join[2] . " JOIN " . $join[0] . " ON " . $join[0] . "." . $join[1] . " = " . $this->tableName . "." . $join[1];
            }

            if (is_array($join[0])) {
                $join = array_reduce(
                    $join,
                    function ($return, $value): string {
                        $return .= $value[2] . " JOIN " . $value[0] . " ON " . $value[0] . "." . $value[1] . " = " . $this->tableName . "." . ($value[3] ?? $value[1]) . " ";

                        return $return;
                    }
                );
            }
        }

        $where = $where ? "WHERE " . $this->tableName . "." . $where[0] . " " . $where[1] . " " . $where[2] . " " . $where[3] : '';

        $sql = "SELECT {$fields} FROM {$this->tableName} {$join} {$where}";
        $consulta = DataBase::conn()->prepare($sql);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_OBJ);

        return $resultado;
    }

    /**
     * @param object $data Recomenda-se receber um dto.
     */
    public function insert(array $data): bool
    {
        $fillable = implode(', ', $this->fillable);

        foreach ($this->fillable as $key => $value) {
            $values[] = $key;
        }

        $values = array_reduce($values, function ($return, $value): string {
            $return .= ":{$value},";
            return $return;
        });

        $values = rtrim($values, ',');

        $sql = "INSERT INTO {$this->tableName} ({$fillable})
                VALUES ({$values})";
        $consulta = DataBase::conn()->prepare($sql);

        foreach ($this->fillable as $key => $value) {
            $consulta->bindParam(":{$key}", $data["$value"]);
        }

        return $consulta->execute();
    }

    public function update(int $id = null, array $data): bool
    {
        $values = "";
        array_walk($data, function ($value, $key) use (&$values): string {
            $values .= "{$key} = :{$key},";

            return $values;
        });

        $values = rtrim($values, ',');
        $where = $id ? 'WHERE id = :id' : '';

        $sql = "UPDATE {$this->tableName} SET {$values} {$where}";
        $consulta = DataBase::conn()->prepare($sql);

        $consulta->bindParam(":id", $id);

        foreach ($data as $key => $value) {
            $consulta->bindParam(":{$key}", $value);
        }

        return $consulta->execute();
    }

    public function deleteOne(int $id): bool
    {
        $where = 'WHERE id = :id';

        $sql = "DELETE FROM {$this->tableName} {$where}";
        $consulta = DataBase::conn()->prepare($sql);
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);

        return $consulta->execute();
    }

    public function delete(array $where = null): bool
    {
        return true;
    }
}
