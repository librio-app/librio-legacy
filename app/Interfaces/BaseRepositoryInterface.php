<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    public function create(array $attributes): Model;
    public function update(int $id, array $attributes): Model;
    public function delete(int $id);

    public function find(int $id): ?Model;
    public function all(): ?Collection;
}
