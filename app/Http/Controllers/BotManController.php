<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use App\Conversations\ExampleConversation;
use GuzzleHttp\Client;
use App\TelegramUser;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->hears('info', function($bot) {
            // get result from DB
            $result = $this->getSummaryCovidInfo();
            // get user detail
            $user = $bot->getUser();
            $id = $user->getId();
            $firstname = $user->getFirstName();
            $lastname = $user->getLastName();
            $username = $user->getUsername();
            // save user detail to DB
            $telegramUser = new TelegramUser;
            $telegramUser->telegram_id = strval($id);
            $telegramUser->username = $username;
            $telegramUser->firstname = $firstname;
            $telegramUser->lastname = $lastname;
            $telegramUser->save();

            $bot->reply($result); 
         });

         $botman->hears('info {province}', function ($bot, $province) {
             // get user detail
            $user = $bot->getUser();
            $id = $user->getId();
            $firstname = $user->getFirstName();
            $lastname = $user->getLastName();
            $username = $user->getUsername();
            // save user detail to DB
            $telegramUser = new TelegramUser;
            $telegramUser->telegram_id = strval($id);
            $telegramUser->username = $username;
            $telegramUser->firstname = $firstname;
            $telegramUser->lastname = $lastname;
            $telegramUser->save();

            $bot->reply("Info Covid-19 Provinsi : ".$province);
            $result = $this->getProvinceInfo($province);
            foreach ($result as $key => $replyText) {
                $bot->reply($replyText);
            }
        });

         $botman->fallback(function ($bot) {
            $bot->reply("Maaf Perintah tidak dikenali. Ketik : info (untuk mendapatkan rangkuman informasi covid-19 di Indonesia atau ketik : info nama_provinsi (untuk informasi rangkuman informasi covid-19 di provinsi tersebut.) ");
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
                "Penderita Covid-19 Meninggal : ". $death . "." . PHP_EOL . 
                "Penderita Covid-19 Sembuh : " . $recovered. "." . PHP_EOL . 
                "Penderita Dalam Perawatan : " . $hospitalized. "." . PHP_EOL;
        
        return $data;
    }

    protected function getProvinceInfo($province)
    {
        $API = 'https://indonesia-covid-19.mathdro.id/api/provinsi';
        $client = new Client();
        $response = $client->get($API)->getBody();
        $responseData = json_decode($response);
        $provincesData = $responseData->{'data'};
        // $data = "Provinsi Tidak Tersedia, Selalu gunakan huruf kapital untuk penulisan contoh :info DKI Jakarta,info Jawa Barat,info Kalimantan Barat,info Banten, dll";
        $data = [];
        foreach ($provincesData as $key => $provinceData) { 
            if (strpos(strtolower($provinceData->provinsi), strtolower($province)) !== false) {
                $replyText = "Berikut adalah rangkuman informasi Covid-19 di Provinsi " . $provinceData->provinsi . " : " . PHP_EOL . 
                "Jumlah Kasus Terkonfirmasi: ".$provinceData->kasusPosi. "." . PHP_EOL . 
                "Penderita Covid-19 Meninggal : ". $provinceData->kasusMeni. "." . PHP_EOL . 
            "Penderita Covid-19 Sembuh : " . $provinceData->kasusSemb. "." . PHP_EOL;
                array_push($data, $replyText);
            }
        }
        return $data;
    }
}
