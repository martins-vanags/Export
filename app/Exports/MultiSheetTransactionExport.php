<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultiSheetTransactionExport implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        return [
            new TransactionsWithLargeAmounts(),
            new TransactionsWithLowAmounts(),
            new TransactionsByUser(9269),
        ];
    }
}
