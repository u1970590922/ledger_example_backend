<?php

namespace App\Services\Finance\Interfaces;

use App\Enums\Finance\LedgerType;
use App\Models\Finance\Ledger;
use Illuminate\Support\Collection;

interface LedgerServiceInterface
{
    /**
     * 取得全部帳本紀錄
     *
     * @return Collection
     */
    public function getAllLedgers(): Collection;

    /**
     * 新增帳本紀錄
     *
     * @param  array  $data
     * @return Ledger
     */
    public function create(array $data): Ledger;

    /**
     * 更新帳本紀錄
     *
     * @param  Ledger  $model
     * @param  array  $data
     * @return Ledger
     */
    public function update(Ledger $model, array $data): Ledger;

    /**
     * 刪除帳本紀錄
     *
     * @param  Ledger  $model
     * @return void
     */
    public function destroy(Ledger $model): void;

    /**
     * 計算餘額
     *
     * @param  integer  $balance
     * @param  int  $amount
     * @param  LedgerType  $type
     * @param  bool  $reverse
     * @return integer
     */
    public function calculateBalance(int $balance, int $amount, LedgerType $type, bool $reverse = false): int;
}