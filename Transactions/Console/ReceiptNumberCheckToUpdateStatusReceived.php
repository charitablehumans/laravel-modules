<?php

namespace Modules\Transactions\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Modules\Rajaongkir\Models\Rajaongkir;
use Modules\Transactions\Models\Transactions;

class ReceiptNumberCheckToUpdateStatusReceived extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'transactions:receipt-number-check-to-update-status-received';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update transaction set status received where receipt number = received';

    protected $rajaongkir;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->rajaongkir = new Rajaongkir;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $transactions = Transactions
            ::where('status', Transactions::$statusSent)
            ->whereNotNull('receipt_number')
            ->get();

        if ($transactions) {
            foreach ($transactions as $transaction) {
                $original = $transaction->getOriginal();
                $waybill = $this->rajaongkir->getWaybill(['waybill' => $transaction->receipt_number, 'courier' => optional($transaction->transactionShipment)->code]);

                if ($waybill && $waybill['delivered'] === true) {
                    $transaction->status = Transactions::$statusReceived;
                    $transaction->save();

                    $this->info('Transaction id: '.$transaction->id.', update status from '.$original['status'].' to '.$transaction->status);
                }
            }
        }
    }
}
