<?php

namespace App\Services\Api\Esim;



class EsimSmApi extends EsimApi
{
    public static function getAllCountries()
    {
        $api = new self();
        $api->setApi('https://esim.sm/api/v1/country');
        $api->setMethod('GET');
        $api->setBody([
            'hl' => 'en',
            'currency' => 'usd',
        ]);
        return $api;
    }
    public static function getPlans(string $countryAlpha2IsoCode)
    {
        $api = new self();
        $api->setApi('https://esim.sm/api/v1/country');
        $api->setMethod('GET');
        $api->setBody([
            'id' => $countryAlpha2IsoCode,
            'hl' => 'en',
            'currency' => 'usd',
        ]);
        return $api;
    }
    public static function getTopCountries()
    {
        $api = new self();
        $api->setApi('https://esim.sm/api/v1/country/top');
        $api->setMethod('GET');
        $api->setBody([
            'hl' => 'en',
            'currency' => 'usd',
        ]);
        return $api;
    }


    public static function getPlan($planId)
    {

        $api = new self();
        $api->setApi('https://esim.sm/api/v1/plan');
        $api->setMethod('GET');
        $api->setBody([
            'id' => $planId,
        ]);
        return $api;
    }

    public static function bundleStatus($iccid)
    {

        $api = new self();
        $api->setApi('https://esim.sm/api/v1/esim');
        $api->setHeaders(['Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImtpZCI6MjEyOTd9.eyJzdWIiOjIxMjk3LCJpc3MiOiIiLCJhdWQiOiIiLCJpYXQiOjE3MTk2NTYwNTEsImV4cCI6MTc1MTE5MjA1MSwianRpIjoiOTNmM2MyMTFlYTE4M2ZiIiwiaWQiOjIxMjk3fQ.kHZkcZQvEbt43SiWZLuIELrSUcN52dT-Kw2qd1sQjZ4']);
       
        $api->setMethod('GET');
        $api->setBody([
            'iccid' => $iccid,
        ]);
        return $api;
    }
    public static function trialPlans()
    {
        $api = new self();
        $api->setApi('https://esim.sm/api/v1/plan/trial');
        $api->setMethod('GET');
        return $api;
    }

    public static function params()
    {

        $api = new self();
        $api->setApi('https://esim.sm/api/v1/params');
        $api->setMethod('GET');
        return $api;
    }

    public static function details($iccid)
    {
        $api = new self();
        $api->setApi('https://esim.sm/api/v1/esim');
        $api->setBody([
            'iccid' => $iccid,
        ]);
        $api->setHeaders(['Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImtpZCI6MjEyOTd9.eyJzdWIiOjIxMjk3LCJpc3MiOiIiLCJhdWQiOiIiLCJpYXQiOjE3MTk2NTYwNTEsImV4cCI6MTc1MTE5MjA1MSwianRpIjoiOTNmM2MyMTFlYTE4M2ZiIiwiaWQiOjIxMjk3fQ.kHZkcZQvEbt43SiWZLuIELrSUcN52dT-Kw2qd1sQjZ4']);
        $api->setMethod('POST');
    }
    public static function purchase($planId, $quantity = 1)
    {
        $api = new self();
        $api->setApi('https://esim.sm/api/v1/esim/purchase');
        $api->setBody([
            'plan_id' => $planId,
            'quantity' => $quantity,
        ]);
        $api->setHeaders(['Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImtpZCI6MjEyOTd9.eyJzdWIiOjIxMjk3LCJpc3MiOiIiLCJhdWQiOiIiLCJpYXQiOjE3MTk2NTYwNTEsImV4cCI6MTc1MTE5MjA1MSwianRpIjoiOTNmM2MyMTFlYTE4M2ZiIiwiaWQiOjIxMjk3fQ.kHZkcZQvEbt43SiWZLuIELrSUcN52dT-Kw2qd1sQjZ4']);
        $api->setMethod('POST');
        return $api;
    }
}
