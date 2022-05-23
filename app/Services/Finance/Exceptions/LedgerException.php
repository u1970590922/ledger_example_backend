<?php

namespace App\Services\Finance\Exceptions;

class LedgerException
{
    public const CANNOT_UPDATE = '無法更新類型與金額';

    public const CANNOT_DELETE = '無法刪除';
}