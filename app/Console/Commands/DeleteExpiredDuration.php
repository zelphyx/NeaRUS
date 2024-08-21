<?php

namespace App\Console\Commands;

use App\Http\Controllers\OrderStatusController;
use Illuminate\Console\Command;

class DeleteExpiredDuration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:clean-expired';
    protected $description = 'Check and delete expired orders';
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $controller = new OrderStatusController();
        $controller->checkAndDeleteExpiredOrders();
        $this->info('Expired orders checked and deleted.');
    }
}
