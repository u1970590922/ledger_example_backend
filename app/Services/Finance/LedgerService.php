<?php

namespace App\Services\Finance;

use App\Enums\Finance\LedgerType;
use App\Exceptions\MessageException;
use App\Models\Finance\Ledger;
use App\Repositories\Finance\LedgerRepository;
use App\Services\Finance\Exceptions\LedgerException;
use App\Services\Finance\Interfaces\LedgerServiceInterface;
use Illuminate\Support\Collection;

class LedgerService implements LedgerServiceInterface
{
    /**
     * 預設使用者編號
     * 
     * @var int
     */
    public const DEFAULT_USER_ID = 1;

    /**
     * LedgerRepository
     *
     * @var LedgerRepository
     */
    protected LedgerRepository $ledgerRepository;

    /**
     * 建構子
     *
     * @param LedgerRepository $ledgerRepository
     */
    public function __construct(LedgerRepository $ledgerRepository)
    {
        $this->ledgerRepository = $ledgerRepository;
    }

    /**
     * 取得全部帳本紀錄
     *
     * @return Collection
     */
    public function getAllLedgers(): Collection
    {
        return $this->ledgerRepository->getAllLedgers();
    }

    /**
     * 新增帳本紀錄
     *
     * @param  array  $data
     * @return Ledger
     */
    public function create(array $data): Ledger
    {
        /**
         * @var ?Ledger
         */
        $ledger = $this->ledgerRepository->getLatest();

        $currentBalance = $ledger ? $ledger->balance : 0;

        $data['balance'] = $this->calculateBalance($currentBalance, $data['amount'], LedgerType::from($data['type']));
        $data['user_id'] = auth()->check() ? auth()->id() : self::DEFAULT_USER_ID;

        return $this->ledgerRepository->create($data);
    }

    /**
     * 更新帳本紀錄
     *
     * @param  Ledger  $model
     * @param  array  $data
     * @return Ledger
     */
    public function update(Ledger $model, array $data): Ledger
    {
        /**
         * @var Ledger
         */
        $ledger = $this->ledgerRepository->getLatest();

        if ($model->amount != $data['amount'] || $model->type != LedgerType::from($data['type'])) {
            if ($model->id != $ledger->id) {
                throw new MessageException(LedgerException::CANNOT_UPDATE);
            } else {
                $data['balance'] = $this->calculateBalance($model->balance, $model->amount, $model->type, true);
                $data['balance'] = $this->calculateBalance($data['balance'], $data['amount'], LedgerType::from($data['type']));
            }
        } else {
            $data = remove_fields($data, ['type', 'amount']);
        }

        return $this->ledgerRepository->update($model, $data);
    }

    /**
     * 刪除帳本紀錄
     *
     * @param  Ledger  $model
     * @return void
     */
    public function destroy(Ledger $model): void
    {
        /**
         * @var Ledger
         */
        $ledger = $this->ledgerRepository->getLatest();

        if ($model->id != $ledger->id) {
            throw new MessageException(LedgerException::CANNOT_DELETE);
        }

        $this->ledgerRepository->delete($model);
    }

    /**
     * 計算餘額
     *
     * @param  integer  $balance
     * @param  int  $amount
     * @param  LedgerType  $type
     * @param  bool  $reverse
     * @return integer
     */
    public function calculateBalance(int $balance, int $amount, LedgerType $type, bool $reverse = false): int
    {
        $result = match($type) {
            LedgerType::EXPEND => true,
            LedgerType::DEPOSIT => false,
        };

        if ($reverse) {
            $result = !$result;
        }

        if ($result) {
            $balance -= $amount;
        } else {
            $balance += $amount;
        }

        return $balance;
    }
}