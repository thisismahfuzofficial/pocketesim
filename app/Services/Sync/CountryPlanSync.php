<?php

namespace App\Services\Sync;

use App\Models\Country;
use App\Models\Plan;
use App\Services\Api\Esim\EsimAccessApi;
use App\Services\Api\Esim\EsimGoApi;
use App\Services\Api\Esim\EsimSmApi;
use Error;
use Exception;
use Illuminate\Support\Facades\DB;

class CountryPlanSync
{

    protected $country;
    public function __construct(Country $country)
    {
        $this->country = $country;
    }

    public function sync()
    {
        try {
            DB::beginTransaction();
            $this->country->plans()->delete();
            if ($this->country->isRegion == true) {

                switch ($this->country->api) {
                    case 'esimsm':
                        $this->syncFromEsimSm();
                        break;
                    default:
                        $this->syncFromEsimGo();
                        break;
                }
            } else {
                switch ($this->country->api) {
                    case 'esimsm':
                        $this->syncFromEsimSm();
                        break;
                    case 'esimgo':
                        $this->syncFromEsimGo();
                        break;
                    case 'esimaccess':
                        $this->syncFromEsimAccess();
                        break;
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        } catch (Error $e) {
            DB::rollBack();
            throw $e;
        }
    }

    protected function syncFromEsimSm()
    {
        $request = EsimSmApi::getPlans($this->country->code)->send();

        if (isset($request['data']) == false) throw new Exception('EsimSm sync failed');
        foreach ($request['data']['plans'] as $plan) {
            if (count($plan['countries']) > 1 && $this->country->isRegion == false) continue;

            Plan::create([
                'country_id' => $this->country->id,
                'plan_code' => $plan['id'],
                'name' => $plan['name'],
                'price' => $plan['price'],
                'data' => $plan['mb'],
                'duration' => $plan['days'],
                'speed' => $plan['networkSpeed'],
                'activationDays' => $plan['activationDays'],
                'api' => 'esimsm',
                'body' => $plan
            ]);
        }
    }

    protected function syncFromEsimGo()
    {
        if ($this->country->isRegion == false) {
            $request = EsimGoApi::getPlans($this->country->code)->send();
        } else {
            $request = EsimGoApi::getPlans(region: $this->country->code)->send();
        }
        if (isset($request['bundles']) == false) throw new Exception('EsimGo sync failed');
        if ($this->country->isRegion == false) {
            $plans = $request['bundles'];
        } else {
            if($this->country->code == 'europe'){
                $plans = collect($request['bundles'])->filter(fn($value,$key)=>$value['countries'][0]['iso'] == 'Europe+')->toArray();
            }elseif($this->country->code == 'south-america'){
                $plans = collect($request['bundles'])->filter(fn($value,$key)=>$value['countries'][0]['iso'] == 'LATAM')->toArray();
            }
            else{
                $plans = collect($request['bundles'])->filter(fn($value,$key)=>$value['countries'][0]['iso'] == $value['countries'][0]['region'])->toArray();
            }
        }
        foreach ($plans as $plan) {
            if(count($plan['countries']) > 1 && $this->country->isRegion == false) continue;
            Plan::create([
                'country_id' => $this->country->id,
                'plan_code' => $plan['name'],
                'name' => $plan['name'],
                'price' => $plan['price'],
                'data' => $plan['dataAmount'] < 1 ? 'Unlimited' : $plan['dataAmount'],
                'duration' => $plan['duration'],
                'speed' => is_array($plan['speed']) ? implode(',', $plan['speed']) : $plan['speed'],
                'activationDays' => null,
                'api' => 'esimgo',
                'body' => $plan
            ]);
        }
    }
    protected function syncFromEsimAccess()
    {
        $request = EsimAccessApi::getPlans($this->country->code)->send();
        if (isset($request['obj']) == false) throw new Exception('EsimAccess sync failed');

        foreach ($request['obj']['packageList'] as $plan) {

            if (count($plan['locationNetworkList']) > 1) continue;
            Plan::create([
                'country_id' => $this->country->id,
                'plan_code' => $plan['packageCode'],
                'name' => $plan['name'],
                'price' => $plan['price'] / 10000,
                'data' => ($plan['volume'] / 1073741824) * 1024,
                'duration' => $plan['duration'],
                'speed' => str_replace('/', ',', $plan['speed']),
                'activationDays' => $plan['unusedValidTime'],
                'api' => 'esimaccess',
                'body' => $plan
            ]);
        }
    }
}
