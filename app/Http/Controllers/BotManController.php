<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use App\Conversations\ExampleConversation;
use GuzzleHttp\Client;
class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');
        // TEST

        $botman->hears('info', function($bot) {
            $result = $this->getSummaryCovidInfo();
            $bot->reply($result); 
         });

        $botman->listen();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tinker()
    {
        return view('tinker');
    }

    /**
     * Loaded through routes/botman.php
     * @param  BotMan $bot
     */
    public function startConversation(BotMan $bot)
    {
        $bot->startConversation(new ExampleConversation());
    }

    protected function getSummaryCovidInfo()
    {
        $API = 'https://indonesia-covid-19.mathdro.id/api';
        $client = new Client();
        $response = $client->get($API)->getBody();
        $responseData = json_decode($response);

        $death = $responseData->meninggal;
        $recovered = $responseData->sembuh;
        $totalCases = $responseData->jumlahKasus;
        $hospitalized = $responseData->perawatan;

        $data = "Berikut adalah rangkuman informasi Covid-19 di Indonesia " . PHP_EOL . 
                "Jumlah Kasus : ".$totalCases . PHP_EOL . 
                "Penderita Covid-19 Meninggal : ". $death . PHP_EOL . 
                "Penderita Covid-19 Sembuh : " . $recovered . PHP_EOL . 
                "Penderita Dalam Perawatan : " . $hospitalized . PHP_EOL;
        
        return $data;
    }
}
