<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use App\Conversations\ExampleConversation;
use GuzzleHttp\Client;
use App\TelegramUser;
use App\NationalReport;
use App\ProvinceReport;

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

            $nationalReport = new NationalReport;
            
            $bot->reply("Info Covid-19 Provinsi $province  periode : " . $nationalReport->latest()->first()->created_at);
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
        // $API = 'https://indonesia-covid-19.mathdro.id/api';
        // $client = new Client();
        // $response = $client->get($API)->getBody();
        // $responseData = json_decode($response);

        // $death = $responseData->meninggal;
        // $recovered = $responseData->sembuh;
        // $totalCases = $responseData->jumlahKasus;
        // $hospitalized = $responseData->perawatan;

        // $nationalReport = new NationalReport;

        // $data = "Berikut adalah rangkuman informasi Covid-19 di Indonesia periode " . $nationalReport->latest()->first()->created_at . ". " . PHP_EOL . 
        //         "Jumlah Kasus : ".$totalCases . PHP_EOL . 
        //         "Penderita Covid-19 Meninggal : ". $death . "." . PHP_EOL . 
        //         "Penderita Covid-19 Sembuh : " . $recovered. "." . PHP_EOL . 
        //         "Penderita Dalam Perawatan : " . $hospitalized. "." . PHP_EOL .
        //         "\n" .
        //         "Kunjungi https://covid.bumi.dev/ untuk peta sebaran per provinsi";
        
        // return $data;


        $nationalData = \App\NationalReport::latest()->first();

        $data = "Berikut adalah rangkuman informasi Covid-19 di Indonesia periode " . $nationalData->latest()->first()->created_at . ". " . PHP_EOL . 
                "Jumlah Kasus : $nationalData->total_cases ". PHP_EOL . 
                "Penderita Covid-19 Meninggal : ". $nationalData->total_death . "." . PHP_EOL . 
                "Penderita Covid-19 Sembuh : " . $nationalData->total_recovered. "." . PHP_EOL . 
                "Penderita Dalam Perawatan : " . $nationalData->total_treated. "." . PHP_EOL .
                "\n" .
                "Kunjungi https://covid.bumi.dev/ untuk peta sebaran per provinsi";
        
        return $data;

    }

    protected function getProvinceInfo($province)
    {
        // $API = 'https://indonesia-covid-19.mathdro.id/api/provinsi';
        // $client = new Client();
        // $response = $client->get($API)->getBody();
        // $responseData = json_decode($response);
        // $provincesData = $responseData->{'data'};
        // $data = [];


        // foreach ($provincesData as $key => $provinceData) { 
        //     if (strpos(strtolower($provinceData->provinsi), strtolower($province)) !== false) {
        //         $replyText = "Berikut adalah rangkuman informasi Covid-19 di Provinsi $provinceData->provinsi  : " . PHP_EOL . 
        //         "Jumlah Kasus Terkonfirmasi: ".$provinceData->kasusPosi. "." . PHP_EOL . 
        //         "Penderita Covid-19 Meninggal : ". $provinceData->kasusMeni. "." . PHP_EOL . 
        //         "Penderita Covid-19 Sembuh : " . $provinceData->kasusSemb. "." . PHP_EOL .
        //         "\n" .
        //         "Kunjungi https://covid.bumi.dev/ untuk peta sebaran per provinsi";
        //         array_push($data, $replyText);
        //     }
        // }

        // return $data;

        $provincesData = \App\NationalReport::latest()->first()->provinces;
        $data = [];
        foreach ($provincesData as $key => $provinceData) { 
            if (strpos(strtolower($provinceData->name), strtolower($province)) !== false) {
                $replyText = "Berikut adalah rangkuman informasi Covid-19 di Provinsi $provinceData->name  : " . PHP_EOL . 
                "Jumlah Kasus Terkonfirmasi: $provinceData->total_cases " . PHP_EOL . 
                "Penderita Covid-19 Meninggal : $provinceData->total_death" . PHP_EOL . 
                "Penderita Covid-19 Sembuh : $provinceData->total_recovered ". PHP_EOL .
                "Kunjungi informasi dari provinsi (rumah sakit, call center, dll) : $provinceData->url " . PHP_EOL .
                "\n" .
                "Kunjungi https://covid.bumi.dev/ untuk peta sebaran per provinsi";
                array_push($data, $replyText);
            }
        }
        return $data;
    }
}
