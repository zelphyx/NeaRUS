<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;

class BotController extends Controller
{
    public function handle()
    {
        $botman = app("botman");
        $botman->hears('{message}', function($botman, $message) {

            if ($message == 'test') {
                $this->askName($botman);
            }

            else{
                $botman->reply("Start a conversation by saying hi.");
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
