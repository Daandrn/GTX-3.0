<?php 

namespace Vendor\Model;

use PDO;

use Vendor\Interfaces\ModelInterface;
use function Config\connection;

require __DIR__.'/../Interfaces/ModelInterface.php';
require __DIR__ .'/../../Config/Connection.php';

class Model implements ModelInterface
{
    protected ?string $className;
    protected array $fillable;
    
    public function __construct(string $className = null, array $fillable)
    {
        $this->className = $className;
        $this->fillable = $fillable;
    }
    
    /**
     * @param array $fields Deve ter o seguinte padrão: ['id', 'nome', 5, '*'] ou ['id as codigo', 'nome'] ou ['tabela.descricao']
     * @param array $join Deve ter o seguinte padrão: ['nome_tabela', 'campo_referencia', 'tipo_join'] ou [['nome_tabela', 'campo_referencia', 'tipo_join'], ['nome_tabela', 'campo_referencia', 'tipo_join']]
     * @param array $where Deve ter o seguinte padrão: ['id', '=', 5, 'ORDER...DESC'] ou ['status', 'in', '(1,2,3)', 'ORDER...DESC']
     */
    public function select(array $fields = ['*'], array $join = null, array $where = null): array
    {
        $fields = implode(',', $fields);
        $fields = rtrim($fields, ',');

        if ($join) {
            if (! is_array($join[0])) {
                $join = $join[2]." JOIN ".$join[0]." ON ".$join[0].".".$join[1]." = ".$this->className.".".$join[1];
            }

            if (is_array($join[0])) {
                $join = array_reduce(
                            $join, function ($return, $value): string {
                                $return .= $value[2]." JOIN ".$value[0]." ON ".$value[0].".".$value[1]." = ".$this->className.".".$value[1]." ";

                                return $return;
                            }
                        );
            }
        }

        $where = $where ? "WHERE ".$this->className.".".$where[0]." ".$where[1]." ".$where[2]." ".$where[3] : '';

        //var_dump("SELECT {$fields} FROM {$this->className} {$join} {$where}");
        $consulta = connection()->prepare("SELECT {$fields} FROM {$this->className} {$join} {$where}");

        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_OBJ);

        return $resultado;
    }
    
    /**
     * @param array $params Recomenda-se receber um dto.
     */
    public function insert(array $params): bool
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
        
        $consulta = connection()->prepare("INSERT INTO {$this->className} ({$fillable})
                                                VALUES ({$values})");

        foreach ($this->fillable as $key => $value) {
            $consulta->bindParam(":{$key}", $params[$key]);
        }
        
        return $consulta->execute();
    }

    public function update(string $id = null, array $data): bool
    {
        $values = array_reduce($data, function ($return, $value, $key): string {    
            $return .= "{$key} = {$value},";  
            return $return;
        });

        $values = rtrim($values, ',');
        $where = $id ? 'WHERE id = :id' : '';

        $consulta = connection()->prepare("UPDATE {$this->className} SET {$values} {$where}");

        if ($id) {
            $consulta->bindParam(":id", $id);
        }

        foreach ($data as $key => $value) {
            $consulta->bindParam(":{$key}", $value);
        }
        
        return $consulta->execute();
    }

    public function delete(string $id): bool
    {
        $where = $id ? 'WHERE id = :id' : '';
        
        $consulta = connection()->prepare("DELETE FROM {$this->className} {$where}");
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);

        return $consulta->execute();
    }
}