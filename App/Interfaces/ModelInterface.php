<?php 

namespace App\Interfaces;

interface ModelInterface
{
    public function select(array $params): array;
    public function insert(object $data): bool;
    public function update(string $id, object $data): bool;
    public function delete(string $id): bool;
}