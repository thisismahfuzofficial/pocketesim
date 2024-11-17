<?php

namespace App\Services\Api\Esim;

use App\Services\Api\Esim\Country\CountryApi;
use App\Services\Api\Esim\Plan\PlanApi;
use Illuminate\Support\Facades\Http;

class EsimGoApi extends EsimApi
{
    const REGIONS = [
        'middle-east' => 'Middle East',
        'Oceania' => 'Oceania',
        'asia' => 'Asia',
        'north-america' => 'North America',
        'south-america' => 'South America',
        'global' => 'Global',
        'europe' => 'Europe',
        'africa' => 'Africa',
        'caribbeans' => 'Caribbean',
    ];
    protected $headers = ['X-API-Key' => 'q9eyhjLEchFHohDbS41OoweyJ4qZg4zlu8M4VP3J'];

    public static function getPlans($country = '', $region = '', $pagination = 10000)
    {
        $api = new self();
        $api->setApi('https://api.esim-go.com/v2.3/catalogue');
        $api->setBody([
            'countries' => $country,
            'region' => $region ? $api::REGIONS[$region] : $region,
            'perPage' => $pagination
        ]);
        return $api;
    }

    public static function purchase($planId, $quantity)
    {

        $api = new self();
        $api->setApi('https://api.esim-go.com/v2.3/orders');
        $api->setBody([
            'type' => 'transaction',
            'assign' => true,
            'Order' => [
                [
                    'type' => 'bundle',
                    'item' => $planId,
                    'quantity' => (int) $quantity
                ]
            ]
        ]);
        $api->setMethod('POST');
        return $api;
    }

    public static function apply($planId)
    {
        $api = new self();
        $api->setApi('https://api.esim-go.com/v2.3/esims/apply');
        $api->setBody([
            'iccid' => "",
            'name' => $planId,
            'startTime' => "",
            "repeat" => 0,
        ]);
        $api->setMethod('POST');
        return $api;
    }
    public static function bundleStatus($iccid, $name)
    {
        $api = new self();
        $api->setApi("https://api.esim-go.com/v2.3/esims/$iccid/bundles/$name");
        $api->setMethod('GET');


        return $api;
    }
    public static function generate($iccid)
    {
        $api = new self();
        $api->setApi('https://api.esim-go.com/v2.3/esims/' . $iccid);
        return $api;
    }
}
