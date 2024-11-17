<?php

namespace App\Services\Purchase;

use App\Models\Order;
use App\Services\Api\Esim\EsimAccessApi;
use App\Services\Api\Esim\EsimGoApi;
use App\Services\Api\Esim\EsimSmApi;
use Error;
use Exception;
use Illuminate\Support\Facades\DB;

class BalanceCheckService
{
    protected $order;
    protected $iccid;
    public function __construct(Order $order, $iccid)
    {
        $this->order = $order;
        $this->iccid = $iccid;
    }
    public static function balance(Order $order, $iccid)
    {
        return (new self($order, $iccid))->checkBalance();
    }

    private function checkBalance()
    {
        switch ($this->order->api) {
            case 'esimaccess':
                $api = EsimAccessApi::bundleStatus(iccid: $this->iccid)->send();
                if ($api['success'] == false) {
                    return [
                        'status' => 'false',
                        'message' => $api['errorMessage'],
                    ];
                }
                return [
                    'status' => 'true',
                    'package' => [
                        'name' => $api['obj']['esimList'][0]['packageList'][0]['packageName'],
                        'id' => $api['obj']['esimList'][0]['packageList'][0]['packageCode'],
                        'mb' => ($api['obj']['esimList'][0]['packageList'][0]['volume'] / 1073741824)  * 1024,
                        'days' => $api['obj']['esimList'][0]['packageList'][0]['duration'],
                    ],
                    'mbTotal' => (int) round($api['obj']['esimList'][0]['totalVolume'] / 1073741824)  * 1024,
                    'mbUsed' => (int) round($api['obj']['esimList'][0]['orderUsage'] / 1073741824)  * 1024,
                    'mbRemaining' => (int) (round($api['obj']['esimList'][0]['totalVolume'] / 1073741824)  * 1024) -  (int) (round($api['obj']['esimList'][0]['orderUsage'] / 1073741824) * 1024),
                ];
            case 'esimsm':
                $api = EsimSmApi::bundleStatus(iccid: $this->iccid)->send();
                if ($api['success'] == false) {
                    return [
                        'status' => 'false',
                        'message' => $api['error'],
                    ];
                }
                return [
                    'status' => 'true',
                    'package' => [
                        'name' => $api['data']['plan']['name'],
                        'id' => $api['data']['plan']['id'],
                        'mb' => $api['data']['plan']['mb'],
                        'days' => $api['data']['plan']['days'],
                    ],
                    'mbTotal' => $api['data']['mbTotal'],
                    'mbUsed' => $api['data']['mbUsed'],
                    'mbRemaining' => $api['data']['mbTotal'] - $api['data']['mbUsed'],
                ];

            default:
                $api =  EsimGoApi::bundleStatus(iccid: $this->iccid, name: $this->order->planID)->send();
                if (isset($api['assignments']) == false) {
                    return [
                        'status' => 'false',
                        'message' => $api['message'],
                    ];
                }
                return [
                    'status' => 'true',
                    'package' => [
                        'name' => $this->order->plan_information->name,
                        'id' => $this->order->plan_information->plan_code,
                        'mb' => $this->order->plan_information->data,
                        'days' => $this->order->plan_information->duration,
                    ],
                    'mbTotal' => $this->order->plan_information->data,
                    'mbUsed' => floor($api['assignments'][0]['remainingQuantity'] / 1073741824),
                    'mbRemaining' => $this->order->plan_information->data -  floor($api['assignments'][0]['remainingQuantity'] / 1073741824),
                ];
        }
    }
}
