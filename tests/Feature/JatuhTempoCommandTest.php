<?php

namespace Tests\Feature;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class JatuhTempoCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_runs_the_jatuh_tempo_command_and_sends_emails()
    {
        Mail::fake();

        // Setup data for the test
        $order = Order::factory()->create([
            'status' => 'Paid',
            'duration' => now()->addDays(7),
            'email' => 'rizqy.astiko19@gmail.com', // Use the test email here
        ]);

        // Run the command
        Artisan::call('orders:jatuh-tempo');

        // Assert that an email was sent
        Mail::assertSent(function ($mail) {
            return $mail->hasTo('rizqy.astiko19@gmail.com');
        });
    }
}
