<?php

namespace Database\Seeders\Finance;

use App\Models\Finance\Ledger;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LedgerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ledger::factory(1)->create();
    }
}
