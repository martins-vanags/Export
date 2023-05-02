<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SimpleTransactionsExport implements FromQuery, WithHeadings, WithMapping, WithChunkReading
{
    use Exportable;

    public function __construct(public array $payload = [])
    {
    }

    public function query(): Relation|Builder
    {
        return Transaction::query()
            ->with('user')
            ->when(Arr::has($this->payload, 'amount'), fn($query) => $query->where('amount', $this->payload['amount']));
    }

    public function headings(): array
    {
        return [
            '#',
            'Description',
            'Amount',
            'User',
            'Created At'
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->description,
            $row->amount,
            $row->user->name,
            $row->created_at
        ];
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
