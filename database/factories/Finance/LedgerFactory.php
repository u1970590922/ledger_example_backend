<?php

namespace Database\Factories\Finance;

use App\Enums\Finance\LedgerType;
use App\Models\Finance\Ledger;
use App\Services\Finance\LedgerService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Finance\Ledger>
 */
class LedgerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ledger::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => LedgerService::DEFAULT_USER_ID,
            'type' => (int) $this->faker->randomElement(enum_values(LedgerType::class)),
            'amount' => rand(1, 9999),
            'description' => '描述內容',
        ];
    }

    /**
     * 增加來源編號
     *
     * @return static
     */
    public function withSource(int $sourceId)
    {
        if (!Ledger::where('id', $sourceId)->exists()) {
            throw new \Exception('無此來源編號');
        }

        return $this->state(function (array $attributes) use($sourceId) {
            return [
                'source_id' => $sourceId
            ];
        });
    }
}
