<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class TransactionsByUser implements FromQuery, WithMapping, WithHeadings, WithTitle
{
    public function __construct(public string $userId)
    {
    }

    public function query(): Relation|Builder
    {
        return Transaction::query()->with(['user'])
            ->where('user_id', '=', $this->userId);
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
        return 'Transactions for user: ' . $this->userId;
    }


}
