<?php

namespace App\Console\Commands;

use App\Models\Bank;
use App\Models\BankList;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class InstallmentFiscalDocument extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'installmentdocument:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Installment Fiscal Document';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        BankList::create([
            'name' => 'تست کرون'
        ]);
        Log::info('Cron Is Working fine!');
    }
}
