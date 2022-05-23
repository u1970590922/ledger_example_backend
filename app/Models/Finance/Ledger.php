<?php

namespace App\Models\Finance;

use App\Enums\Finance\LedgerType;
use Database\Factories\Finance\LedgerFactory;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Finance\Traits\Relations\LedgerRelation;

/**
 * Ledger Model
 * 
 * @property int $id
 * @property int $user_id
 * @property LedgerType $type
 * @property int $amount
 * @property int $balance
 * @property string $description
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class Ledger extends Model
{
    use HasFactory,
        LedgerRelation;

    /**
     * 模型關聯表
     *
     * @var string
     */
    protected $table = 'ledgers';

    /**
     * 可批量分配的屬性
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'source_id',
        'type',
        'amount',
        'balance',
        'description',
    ];

    /**
     * 轉換的屬性
     *
     * @var array
     */
    protected $casts = [
        'type' => LedgerType::class,
    ];

    /**
     * 模型工廠實例
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return LedgerFactory::new();
    }
}
