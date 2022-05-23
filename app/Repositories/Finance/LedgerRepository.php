<?php

namespace App\Repositories\Finance;

use App\Models\Finance\Ledger;
use App\Repositories\Repository;
use Illuminate\Support\Collection;

class LedgerRepository extends Repository
{
    /**
     * 建構子
     *
     * @param Ledger $model
     */
    public function __construct(Ledger $model)
    {
        $this->model = $model;
    }

    /**
     * 取得全部帳本紀錄(包含user)
     *
     * @return Collection
     */
    public function getAllLedgers(): Collection
    {
        return $this->model->with(['user'])
            ->selectRaw('*, IF( id = ( SELECT id FROM ledgers ORDER BY created_at DESC LIMIT 1 ), TRUE, FALSE ) AS is_latest')
            ->latest()
            ->get();
    }
}