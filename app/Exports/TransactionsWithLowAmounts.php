<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class TransactionsWithLowAmounts implements FromQuery, WithTitle, WithMapping, WithHeadings
{
    public function query(): Relation|Builder
    {
        return Transaction::query()->with('user')->where('amount', '<', 15000);
    }

    public function headings(): array
    {
        return [
            'User',
            'Amount',
        ];
    }

    public function map($row): array
    {
        return [
            $row->user->name,
            $row->amount
        ];
    }

    public function title(): string
    {
        return 'Transactions with low amounts';
    }


}
