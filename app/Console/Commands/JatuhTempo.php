<?php

namespace App\Console\Commands;

use App\Http\Controllers\OrderStatusController;
use Illuminate\Console\Command;

class JatuhTempo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:jatuh-tempo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Jatuh Tempo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $controller = new OrderStatusController();
        $controller->alerttempo();
        $this->info('Sudah Jatuh Tempo dan Anda Belum Membayar, Data Dihapus.');
    }
}
