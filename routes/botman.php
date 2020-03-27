<?php

use App\Conversations\CovidConversation;
use App\Http\Controllers\BotManController;
use App\TelegramUser;

$botman = resolve('botman');

$botman->hears('Hi', function ($bot) {
    $user = $bot->getUser();
    // Access first name
    $id = $user->getId();
    $firstname = $user->getFirstName();
    $lastname = $user->getLastName();
    $username = $user->getUsername();

    $telegramUser = new TelegramUser;
    $telegramUser->telegram_id = strval($id);
    $telegramUser->username = $username;
    $telegramUser->firstname = $firstname;
    $telegramUser->lastname = $lastname;
    $telegramUser->save();

    $greeting = "Hi $firstname  .  Ketik : info (untuk mendapatkan rangkuman informasi covid-19 di Indonesia atau ketik : info nama_provinsi (untuk informasi rangkuman informasi covid-19 di provinsi tersebut.) ";
    $bot->reply($greeting);
});

$botman->hears('Help', function ($bot) {
    $user = $bot->getUser();
    // Access first name
    $id = $user->getId();
    $firstname = $user->getFirstName();
    $lastname = $user->getLastName();
    $username = $user->getUsername();

    $telegramUser = new TelegramUser;
    $telegramUser->telegram_id = strval($id);
    $telegramUser->username = $username;
    $telegramUser->firstname = $firstname;
    $telegramUser->lastname = $lastname;
    $telegramUser->save();

    $greeting = "Hi $firstname  .  Ketik : info (untuk mendapatkan rangkuman informasi covid-19 di Indonesia atau ketik : info nama_provinsi (untuk informasi rangkuman informasi covid-19 di provinsi tersebut.) ";
    $bot->reply($greeting);
});
$botman->hears('Hello', function ($bot) {
    $user = $bot->getUser();
    // Access first name
    $id = $user->getId();
    $firstname = $user->getFirstName();
    $lastname = $user->getLastName();
    $username = $user->getUsername();

    $telegramUser = new TelegramUser;
    $telegramUser->telegram_id = strval($id);
    $telegramUser->username = $username;
    $telegramUser->firstname = $firstname;
    $telegramUser->lastname = $lastname;
    $telegramUser->save();

    $greeting = "Hi $firstname  .  Ketik : info (untuk mendapatkan rangkuman informasi covid-19 di Indonesia atau ketik : info nama_provinsi (untuk informasi rangkuman informasi covid-19 di provinsi tersebut.) ";
    
    $bot->reply($greeting);
});

// $botman->hears('Start conversation', BotManController::class.'@startConversation');
$botman->hears('start', function ($bot) {
    $bot->startConversation(new CovidConversation());
});
$botman->hears('/start', function ($bot) {
    $bot->startConversation(new CovidConversation());
});
