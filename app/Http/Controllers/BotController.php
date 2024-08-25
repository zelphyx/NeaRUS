<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;
use Illuminate\Support\Facades\Redirect;

class BotController extends Controller
{

    public function handlechat(Request $request){
        $message = $request->input('message');

        switch ($message) {
            case 'apa itu website nearus':
                $response = "Website NeaRUS adalah sebuah website yang digunakan untuk menyewa kamar kost, management kost, serta informasi tentang kost di sekitar SMK Raden Umar Said";
                break;
            case 'bagaimana cara melakukan pemesanan kos di nearus':
                $response = "Cara melakukan pemesanan kost yaitu dengan langsung memilih dan memesan kamar melalui detail dari masing-masing kost yang diinginkan";
                break;
            case 'bagaimana sistem perpanjangan sewa di nearus':
                $response = "Sistem perpanjangan di NeaRUS yaitu sistem untuk menambah jangka waktu sewa dari penyewa kost ";
                break;
            case 'tentang nearus finance':
                $response = "NeaRus Finance adalah tempat untuk mengontrol kost yang telah disewa";
                break;
            case 'hubungi admin':
                return response()->json([
                    'message' => 'Redirecting to admin',
                    'redirect_url' => 'https://wa.me/6281380895499'
                ]);
            default:
                $response = "Maaf Kami Tidak Mengerti Tentang Pertanyaan Anda, Silahkan Tanyakan Kepada Admin Kami" . $message;
                break;
        }

        return response()->json([
            'message' => $response
        ]);
    }
    public function handle()
    {
        $botman = app("botman");
        $botman->hears('apa itu nearus', function($botman) {
            $botman->reply('nearus adalah ...');
        });

        $botman->hears('siapa saja developer nearus', function($botman) {
            $botman->reply('developer dari nearus adalah ...');
        });
        $botman->hears('bisakah saya mendapat contact admin center nearus', function($botman) {
            $botman->reply('Silahkan hubungi WhatsApp berikut: https://wa.me/1234567890');
        });
        $botman->hears('{message}', function($botman, $message) {
            if ($message == 'test') {
                $this->askName($botman);
            }

        });

        $botman->listen();
    }

    /**
     * Place your BotMan logic here.
     */
    public function askName($botman)
    {
        $botman->ask('Hello! What is your Name?', function(Answer $answer) {

            $name = $answer->getText();

            $this->say('Nice to meet you '.$name);
        });
    }

}
