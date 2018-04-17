<?php

namespace Modules\Transactions\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Modules\Transactions\Models\Transactions\Sales;

class SalesStatusPendingDueDate extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'transactions:sales-status-pending-due-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update transaction to returned when status pending and due date.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($sales = Sales::where('status', 'pending')->where('due_date', '<=', date('Y-m-d H:i:s'))->get()) {
            foreach ($sales as $sale) {
                (new Sales)->reject($sale->id);
                $this->info('Transaction Id'.$sale->id.' returned');
            }
        }
    }
}
