<?php

namespace App\Jobs;

use App\Exports\TransactionsByMonth;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class TransactionsByMonthJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        // $this->onQueue();
    }

    public function handle(): void
    {
        (new \App\Exports\TransactionsByMonth())->store('public/transactionsByMonth.xlsx');
    }

    public function failed(Throwable $exception): void
    {
        // Simple example, don't know if it works tho.

        (new TransactionsByMonth())->export->update([
            'stack_trace' => json_encode($exception),
            'status' => 'failed',
        ]);
    }
}
