<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NationalReport;
use App\ProvinceReport;
Use GuzzleHttp\Client;

class NationalReportController extends Controller
{
    public function refresh(){
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
                break;
                case 'jawa barat':
                    $provinceReport->code = 'ID-JB';
                break;
                case 'banten':
                    $provinceReport->code = 'ID-BT';
                break;
                case 'jawa timur':
                    $provinceReport->code = 'ID-JI';
                break;
                case 'jawa tengah':
                    $provinceReport->code = 'ID-JT';
                break;
                case 'kalimantan timur':
                    $provinceReport->code = 'ID-KI';
                break;
                case 'daerah istimewa yogyakarta':
                    $provinceReport->code = 'ID-YO';
                break;
                case 'kepulauan riau':
                    $provinceReport->code = 'ID-KR';
                break;
                case 'bali':
                    $provinceReport->code = 'ID-BA';
                break;
                case 'sulawesi tenggara':
                    $provinceReport->code = 'ID-SG';
                break;
                case 'sumatera utara':
                    $provinceReport->code = 'ID-SU';
                break;
                case 'kalimantan barat':
                    $provinceReport->code = 'ID-KB';
                break;
                case 'kalimantan tengah':
                    $provinceReport->code = 'ID-KT';
                break;
                case 'sulawesi selatan':
                    $provinceReport->code = 'ID-SS';
                break;
                case 'papua':
                    $provinceReport->code = 'ID-PA';
                break;
                case 'riau':
                    $provinceReport->code = 'ID-RI';
                break;
                case 'lampung':
                    $provinceReport->code = 'ID-LA';
                break;
                case 'kalimantan selatan':
                    $provinceReport->code = 'ID-KS';
                break;
                case 'sulawesi utara':
                    $provinceReport->code = 'ID-SA';
                break;
                case 'maluku':
                    $provinceReport->code = 'ID-MA';
                break;
                case 'aceh':
                    $provinceReport->code = 'ID-AC';
                break;
                case 'sumatera barat':
                    $provinceReport->code = 'ID-SB';
                break;
                case 'jambi':
                    $provinceReport->code = 'ID-JA';
                break;
                case 'sumatera selatan':
                    $provinceReport->code = 'ID-SS';
                break;
                case 'bengkulu':
                    $provinceReport->code = 'ID-BE';
                break;
                case 'kepulauan bangka belitung':
                    $provinceReport->code = 'ID-BB';
                break;
                case 'nusa tenggara barat':
                    $provinceReport->code = 'ID-NB';
                break;
                case 'nusa tenggara timur':
                    $provinceReport->code = 'ID-NT';
                break;
                case 'kalimantan utara':
                    $provinceReport->code = 'ID-KU';
                break;
                case 'sulawesi tengah':
                    $provinceReport->code = 'ID-ST';
                break;
                case 'gorontalo':
                    $provinceReport->code = 'ID-GO';
                break;
                case 'sulawesi barat':
                    $provinceReport->code = 'ID-SR';
                break;
                case 'maluku utara':
                    $provinceReport->code = 'ID-MU';
                break;
                case 'papua barat':
                    $provinceReport->code = 'ID-PB';
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
    return redirect()->back();
}
}
