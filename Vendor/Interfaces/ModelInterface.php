<?php

namespace Vendor\Interfaces;

require_once __DIR__ . '/../autoload.php';

interface ModelInterface
{
    public function select(array $params): array;
    public function insert(array $data): bool;
    public function update(int $id, array $data): bool;
    public function deleteOne(int $id): bool;
    public function delete(array $where): bool;
}
