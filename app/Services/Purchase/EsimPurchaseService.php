<?php

namespace App\Services\Purchase;

use App\Models\Order;
use App\Services\Api\Esim\EsimAccessApi;
use App\Services\Api\Esim\EsimGoApi;
use App\Services\Api\Esim\EsimSmApi;
use Error;
use Exception;
use Illuminate\Support\Facades\DB;

class EsimPurchaseService
{

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function purchase()
    {
        try {
            switch ($this->order->api) {
                case 'esimsm':
                    return $this->purchaseFromEsimSm();
                    break;
                case 'esimgo':
                    return  $this->purchaseFromEsimGo();
                    break;
                case 'esimaccess':
                    return  $this->purchaseFromEsimAccess();
                    break;
            }
        } catch (Exception $e) {

            throw $e;
        } catch (Error $e) {
            throw $e;
        }
    }

    protected function purchaseFromEsimSm()
    {
        $qr = [];
        $iccids = [];
        $data = [];
        $request = EsimSmApi::purchase($this->order->planID, $this->order->quantity)->send();

        if (isset($request['data']['esim'])) {

            foreach ($request['data']['esim'] as $esim) {

                array_push($qr, $esim['lpaCode']);
                array_push($iccids, $esim['iccid']);
            }
            $data['qr'] = $qr;
            $data['iccids'] = $iccids;
            return $data;
        }

        throw new Exception("Could not purchase");
    }
    protected function purchaseFromEsimGo()
    {
        $data = [];
        $qr = [];

        $createOrder = EsimGoApi::purchase($this->order->planID, $this->order->quantity)->send();
        if ($createOrder['status'] == 'completed') {

            foreach ($createOrder['order'][0]['esims'] as $esim) {
                $smdpAddress = $esim['smdpAddress'];
                $matchingID = $esim['matchingId'];
                array_push($qr, "LPA:1$" . $smdpAddress . '$' . $matchingID);
            }
            $data['qr'] = $qr;
            $data['iccids'] = $createOrder['order'][0]['iccids'];

            return $data;
        }

        throw new Exception("Could not purchase");
    }
    protected function purchaseFromEsimAccess()
    {
        $data = [];
        $qr = [];
        $iccids = [];
        $orderRequest = EsimAccessApi::purchase($this->order->planID, $this->order->quantity)->send();

        if (isset($orderRequest['obj']['orderNo'])) {
            sleep(35);
            $orderDetails = EsimAccessApi::orderDetails($orderRequest['obj']['orderNo'])->send();
            

            if (isset($orderDetails['obj']['esimList'])) {
                foreach ($orderDetails['obj']['esimList'] as $esim) {
                    array_push($qr, $esim['ac']);
                    array_push($iccids, $esim['iccid']);
                }
                $data['qr'] = $qr;
                $data['iccids'] = $iccids;
                return $data;
            }
        }
        throw new Exception("Could not purchase");
    }
}
