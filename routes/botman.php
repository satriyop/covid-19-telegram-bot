<?php
use App\Http\Controllers\BotManController;
use App\Http\Controllers\CovidInfoController;


$botman = resolve('botman');

// $botman->hears('Start conversation', BotManController::class.'@startConversation');
$botman->hears('Hi', function ($bot) {
    $greeting = "Informasi tentang Covid-19 di Indonesia. Ketik info (untuk rangkuman informasi)";

    $bot->reply($greeting);
});
// $botman->hears('Start conversation', BotManController::class.'@startConversation');


