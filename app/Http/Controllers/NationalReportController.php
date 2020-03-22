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
            $provinceReport->name = $provinceData->provinsi;
            $provinceReport->total_cases = $provinceData->kasusPosi;
            $provinceReport->total_recovered = $provinceData->kasusSemb;
            $provinceReport->total_death = $provinceData->kasusMeni;
            $nationalReport->provinces()->save($provinceReport);
        }

    }
}
