<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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

    public function failed()
    {

    }
}
