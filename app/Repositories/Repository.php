<?php

namespace App\Repositories;

use InvalidArgumentException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class Repository implements RepositoryInterface
{
    /**
     * 模型
     *
     * @var Model
     */
    protected Model $model;

    /**
     * 創建新模型實例
     *
     * @return Model
     */
    public function newModel(): Model
    {
        return new $this->model();
    }

    /**
     * 創建新查詢建構器
     *
     * @return Builder
     */
    public function newQuery(): Builder
    {
        return $this->model->newQuery();
    }

    /**
     * 傳入id並取得模型
     *
     * @param  integer|string  $id
     * @return ?Model
     */
    public function getById(int|string $id): ?Model
    {
        return $this->newQuery()->find($id);
    }

    /**
     * 傳入欄位名與值並取得模型集合
     *
     * @param  string  $column
     * @param  mixed  $operator
     * @param  mixed|null  $value
     * @return Collection
     */
    public function getByColumn(string $column, $operator, $value = null): Collection
    {
        $query = $this->newQuery();

        if (func_num_args() === 2) {
            $value = $operator;
            $operator = '=';
        }

        if (is_array($value) || $$value instanceof Arrayable) {
            $query = $query->whereIn($column, $value);
        } else {
            $query = $query->where($column, $operator, $value);
        }

        return $query->get();
    }

    /**
     * 取得最後一筆紀錄
     *
     * @return ?Model
     */
    public function getLatest(): ?Model
    {
        return $this->newQuery()->latest()->first();
    }

    /**
     * 新增資料
     *
     * @param  array  $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->newModel()->create($data);
    }

    /**
     * 傳入模型與新資料並更新
     *
     * @param  Model  $model
     * @param  array  $data
     * @return Model
     */
    public function update(Model $model, array $data): Model
    {
        return tap($model)->update($data);
    }

    /**
     * 傳入模型並刪除
     *
     * @param  Model  $model
     * @return Model
     */
    public function delete(Model $model): Model
    {
        $model->delete();

        return $model;
    }

    /**
     * 傳入模型並刪除(僅適用於有軟刪除的模型)
     *
     * @param  Model  $model
     * @return Model
     * 
     * @throws InvalidArgumentException
     */
    public function forceDelete(Model $model): Model
    {
        if ($this->modelHasSoftDelete($model)) {
            $model->forceDelete();
            return $model;
        }

        throw new InvalidArgumentException('無法使用forceDelete刪除，此 ' . get_class($model) . ' 模型沒有軟刪除。');
    }

    /**
     * 傳入模型並從軟刪除中復原(僅適用於有軟刪除的模型)
     *
     * @param  Model  $model
     * @return Model
     * 
     * @throws InvalidArgumentException
     */
    public function restore(Model $model): Model
    {
        if ($this->modelHasSoftDelete($model)) {
            $model->restore();
            return $model;
        }

        throw new InvalidArgumentException('無法復原，此 ' . get_class($model) . ' 模型沒有軟刪除。');
    }

    /**
     * 確認傳入的模型是否有軟刪除
     *
     * @param  Model  $model
     * @return bool
     */
    private function modelHasSoftDelete(Model $model): bool
    {
        return in_array(SoftDeletes::class, class_uses($model));
    }
}
