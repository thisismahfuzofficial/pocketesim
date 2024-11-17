<?php

namespace App\Services\Api\Esim;


class EsimAccessApi extends EsimApi
{
    protected $method = 'POST';
    protected $headers = ['RT-AccessCode' => '803b4b75f7284027a55012e76f2d16f9'];

    public static function getPlans($locationCode = ''): self
    {
        $api = new self();
        $api->setApi('https://api.esimaccess.com/api/v1/open/package/list');
        $api->setBody([
            'locationCode' => $locationCode,

        ]);
        return $api;
    }

   
    public static function purchase($planId, $quantity = 1): self
    {
        $api = new self();
        $api->setApi('https://api.esimaccess.com/api/v1/open/esim/order');
        $api->setBody([
            'transactionId' => uniqid(),
            'packageInfoList' => [[
                'packageCode' => $planId,
                'count' => $quantity,
                // 'price' => 76000
            ]]
        ]);
        return $api;
    }
    public static function bundleStatus($iccid): self
    {
        $api = new self();
        $api->setApi('https://api.esimaccess.com/api/v1/open/esim/query');
        $api->setBody([
            'iccid' => $iccid,
            'pager' => [
                'pageNum' => 1,
                'pageSize' => 20,
            ]
        ]);
        return $api;
    }


    public static function orderDetails($orderNo)
    {
        $api = new self();
        $api->setApi('https://api.esimaccess.com/api/v1/open/esim/query');
        $api->setBody([
            'orderNo' => $orderNo,
            'pager' => [
                'pageNum' => 1,
                'pageSize' => 20,
            ]
        ]);
        return $api;
    }
}
