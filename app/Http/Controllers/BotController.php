<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;

class BotController extends Controller
{

    public function handlechat(Request $request){
        $message = $request->input('message');

        // Misalnya ini adalah response dari chatbot
        $response = "Ini adalah respon dari chatbot untuk pesan: " . $message;

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
