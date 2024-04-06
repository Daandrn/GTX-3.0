<?php 

namespace Vendor\Interfaces;

use stdClass;

interface ModelInterface
{
    public function select(array $params): array;
    public function insert(array $data): bool;
    public function update(string $id, array $data): bool;
    public function delete(string $id): bool;
}