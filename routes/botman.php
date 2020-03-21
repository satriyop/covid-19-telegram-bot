<?php
use App\Http\Controllers\BotManController;
use App\Http\Controllers\CovidInfoController;


$botman = resolve('botman');

$botman->hears('Hi', function ($bot) {
    $greeting = "Ketik : info (untuk mendapatkan rangkuman informasi covid-19 di Indonesia atau ketik : info nama_provinsi (untuk informasi rangkuman informasi covid-19 di provinsi tersebut.) ";
    $bot->reply($greeting);
});
$botman->hears('Halo', function ($bot) {
    $greeting = "Ketik : info (untuk mendapatkan rangkuman informasi covid-19 di Indonesia atau ketik : info nama_provinsi (untuk informasi rangkuman informasi covid-19 di provinsi tersebut.) ";
    $bot->reply($greeting);
});
// $botman->hears('Start conversation', BotManController::class.'@startConversation');


