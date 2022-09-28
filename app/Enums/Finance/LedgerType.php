<?php

namespace App\Enums\Finance;

enum LedgerType: int {
    case EXPEND = 1; //支出
    case DEPOSIT = 2; //存入
}