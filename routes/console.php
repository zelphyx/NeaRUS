<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();
(new Illuminate\Console\Scheduling\Schedule)->command('orders:clean-expired');
(new Illuminate\Console\Scheduling\Schedule)->command('orders:jatuh-tempo');

