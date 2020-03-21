<?php
namespace App\Conversations;
use BotMan\BotMan\Messages\Conversations\Conversation;

class CovidConversation extends Conversation 
{
    public function run()
    {
        $this->showInfo();
    }

    private function showInfo()
    {
        $this->say('Ketik : info (untuk mendapatkan rangkuman informasi covid-19 di Indonesia atau ketik : info nama_provinsi (untuk informasi rangkuman informasi covid-19 di provinsi tersebut 🍀');
    }
}