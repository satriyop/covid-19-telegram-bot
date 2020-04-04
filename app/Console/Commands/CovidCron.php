<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\NationalReport;
use App\ProvinceReport;
use Illuminate\Support\Facades\Config;

class CovidCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'covid:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Log::info('Covid Cron Working Properly...');
        $NATIONAL_API = 'https://indonesia-covid-19.mathdro.id/api';
        $PROVINCE_API = 'https://indonesia-covid-19.mathdro.id/api/provinsi';

        // Request to API
        $client = new Client();
        $response = $client->get($NATIONAL_API)->getBody();

        // Parse data from API
        $responseData = json_decode($response);
        $death = $responseData->meninggal;
        $recovered = $responseData->sembuh;
        $totalCases = $responseData->jumlahKasus;
        $hospitalized = $responseData->perawatan;

        // save to DB
        $nationalReport = new NationalReport;
        $nationalReport->total_cases = $totalCases;
        $nationalReport->total_death = $death;
        $nationalReport->total_recovered = $recovered;
        $nationalReport->total_treated = $hospitalized;
        $nationalReport->save();

        // follow up to get Province Data 

        // Request to API
        $client = new Client();
        $response = $client->get($PROVINCE_API)->getBody();

        // parse data from API
        $responseData = json_decode($response);
        $provincesData = $responseData->{'data'};

        foreach ($provincesData as $key => $provinceData) {
            $provinceReport = new ProvinceReport;
            switch (strtolower($provinceData->provinsi)) {
                case 'dki jakarta':
                    $provinceReport->code = 'ID-JK';
                    $provinceReport->url = Config::get('province.jakarta');
                    break;
                case 'jawa barat':
                    $provinceReport->code = 'ID-JB';
                    $provinceReport->url = Config::get('province.jabar');
                    break;
                case 'banten':
                    $provinceReport->code = 'ID-BT';
                    $provinceReport->url = Config::get('province.banten');
                    break;
                case 'jawa timur':
                    $provinceReport->code = 'ID-JI';
                    $provinceReport->url = Config::get('province.jatim');
                    break;
                case 'jawa tengah':
                    $provinceReport->code = 'ID-JT';
                    $provinceReport->url = Config::get('province.jateng');
                    break;
                case 'kalimantan timur':
                    $provinceReport->code = 'ID-KI';
                    $provinceReport->url = Config::get('province.kaltim');
                    break;
                case 'daerah istimewa yogyakarta':
                    $provinceReport->code = 'ID-YO';
                    $provinceReport->url = Config::get('province.jogjakarta');
                    break;
                case 'kepulauan riau':
                    $provinceReport->code = 'ID-KR';
                    $provinceReport->url = Config::get('province.kepri');
                    break;
                case 'bali':
                    $provinceReport->code = 'ID-BA';
                    $provinceReport->url = Config::get('province.bali');
                    break;
                case 'sulawesi tenggara':
                    $provinceReport->code = 'ID-SG';
                    $provinceReport->url = Config::get('province.jogjakarta');
                    break;
                case 'sumatera utara':
                    $provinceReport->code = 'ID-SU';
                    $provinceReport->url = Config::get('province.sumut');
                    break;
                case 'kalimantan barat':
                    $provinceReport->code = 'ID-KB';
                    $provinceReport->url = Config::get('province.kalbar');
                    break;
                case 'kalimantan tengah':
                    $provinceReport->code = 'ID-KT';
                    $provinceReport->url = Config::get('province.kalteng');
                    break;
                case 'sulawesi selatan':
                    $provinceReport->code = 'ID-SS';
                    $provinceReport->url = Config::get('province.sulsel');
                    break;
                case 'papua':
                    $provinceReport->code = 'ID-PA';
                    $provinceReport->url = Config::get('province.papua');
                    break;
                case 'riau':
                    $provinceReport->code = 'ID-RI';
                    $provinceReport->url = Config::get('province.riau');
                    break;
                case 'lampung':
                    $provinceReport->code = 'ID-LA';
                    $provinceReport->url = Config::get('province.lampung');
                    break;
                case 'kalimantan selatan':
                    $provinceReport->code = 'ID-KS';
                    $provinceReport->url = Config::get('province.kalsel');
                    break;
                case 'sulawesi utara':
                    $provinceReport->code = 'ID-SA';
                    $provinceReport->url = Config::get('province.sulut');
                    break;
                case 'maluku':
                    $provinceReport->code = 'ID-MA';
                    $provinceReport->url = Config::get('province.maluku');
                    break;
                case 'aceh':
                    $provinceReport->code = 'ID-AC';
                    $provinceReport->url = Config::get('province.aceh');
                    break;
                case 'sumatera barat':
                    $provinceReport->code = 'ID-SB';
                    $provinceReport->url = Config::get('province.sumbar');
                    break;
                case 'jambi':
                    $provinceReport->code = 'ID-JA';
                    $provinceReport->url = Config::get('province.jambi');
                    break;
                case 'sumatera selatan':
                    $provinceReport->code = 'ID-SS';
                    $provinceReport->url = Config::get('province.sumsel');
                    break;
                case 'bengkulu':
                    $provinceReport->code = 'ID-BE';
                    $provinceReport->url = Config::get('province.bengkulu');
                    break;
                case 'kepulauan bangka belitung':
                    $provinceReport->code = 'ID-BB';
                    $provinceReport->url = Config::get('province.babel');
                    break;
                case 'nusa tenggara barat':
                    $provinceReport->code = 'ID-NB';
                    $provinceReport->url = Config::get('province.ntb');
                    break;
                case 'nusa tenggara timur':
                    $provinceReport->code = 'ID-NT';
                    $provinceReport->url = Config::get('province.ntt');
                    break;
                case 'kalimantan utara':
                    $provinceReport->code = 'ID-KU';
                    $provinceReport->url = Config::get('province.kaltara');
                    break;
                case 'sulawesi tengah':
                    $provinceReport->code = 'ID-ST';
                    $provinceReport->url = Config::get('province.sulteng');
                    break;
                case 'gorontalo':
                    $provinceReport->code = 'ID-GO';
                    $provinceReport->url = Config::get('province.gorontalo');
                    break;
                case 'sulawesi barat':
                    $provinceReport->code = 'ID-SR';
                    $provinceReport->url = Config::get('province.sulbar');
                    break;
                case 'maluku utara':
                    $provinceReport->code = 'ID-MU';
                    $provinceReport->url = Config::get('province.malut');
                    break;
                case 'papua barat':
                    $provinceReport->code = 'ID-PB';
                    $provinceReport->url = Config::get('province.pabar');
                    break;
                default:
                    $provinceReport->code = 'Unknown';
                    break;
            }

            $provinceReport->name = $provinceData->provinsi;
            $provinceReport->total_cases = $provinceData->kasusPosi;
            $provinceReport->total_recovered = $provinceData->kasusSemb;
            $provinceReport->total_death = $provinceData->kasusMeni;
            $nationalReport->provinces()->save($provinceReport);
        }
    }
}
