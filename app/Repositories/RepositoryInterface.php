<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public function newModel(): Model;

    public function newQuery(): Builder;

    public function getById(int $id): ?Model;

    public function getByColumn(string $column, $value): Collection;

    public function getLatest(): ?Model;

    public function create(array $data): Model;

    public function update(Model $model, array $data): Model;

    public function delete(Model $model): Model;

    public function forceDelete(Model $model): Model;

    public function restore(Model $model): Model;
}
