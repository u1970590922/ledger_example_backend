<?php

namespace App\Enums\Finance;

enum LedgerType: int {
    case EXPEND = 1;
    case DEPOSIT = 2;
}