<?php

namespace App\Exports;

use App\Models\Export;
use App\Models\Transaction;
use Illuminate\Console\OutputStyle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;

class TransactionsByMonth implements WithMapping, WithHeadings, WithTitle, FromQuery, WithChunkReading, WithEvents
{
    use Exportable;

    public Model|Builder $export;
    public int $totalRows;

    public function registerEvents(): array
    {
        $this->totalRows = $this->query()->get()->count();

        return [
            BeforeExport::class => function () {
                $this->export = Export::query()->create([
                    'type' => 'TransactionsByMonth',
                    'file_path' => 'public/transactionsByMonth.xlsx',
                    'status' => 'started',
                    'query_count' => $this->query()->count(),
                    'total_rows' => $this->totalRows,
                    'content' => json_encode([
                        'query' => $this->query()->toSql(),
                        'bindings' => $this->query()->getBindings(),
                    ]),
                ]);
            },
            BeforeWriting::class => function () {
                $this->export->update([
                    'status' => 'completed',
                ]);
            },
        ];
    }


    public function query(): Relation|Builder
    {
        return Transaction::query()->select(DB::raw('SUM(amount) as total'), DB::raw('strftime("%m", created_at) as month'))
            ->groupBy(DB::raw('strftime("%m", created_at)'));
    }

    public function headings(): array
    {
        return [
            'Amount',
            'Month',
        ];
    }

    public function map($row): array
    {
        $this->export->increment('processed_rows');

        return [
            $row->total,
            $row->month
        ];
    }

    public function title(): string
    {
        return 'Transactions count for 12 months';
    }

    public function chunkSize(): int
    {
        return 900;
    }
}
