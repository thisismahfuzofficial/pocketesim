<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Models\Plan;
use App\Services\Api\Esim\EsimSmApi;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EsimApiSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:esim-api-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync eSIM API data with local database';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        try {

            $this->syncCountries();
            // $this->syncFeaturedCountries();
            // $this->syncPlans();
            $this->info('eSIM API sync completed successfully.');
        } catch (Exception $e) {
            Log::error('eSIM API sync failed', ['exception' => $e]);
            $this->error('eSIM API sync failed. Check logs for details.');
        }
    }

    /**
     * Sync countries from eSIM API.
     *
     * @return void
     */
    protected function syncCountries(): void
    {
        $allCountries = EsimSmApi::getAllCountries()->send();

        if ($allCountries['success'] === false) {
            Log::error('Failed to fetch countries', $allCountries);
            throw new Exception('Failed to fetch countries from eSIM API');
        }

        foreach ($allCountries['data'] as $data) {

            if ($data['isRegion'] == 1) {
                Country::updateOrCreate(
                    ['code' => $data['id']],
                    [
                        'isRegion' => true,
                        'code' => $data['id'],
                        'name' => $data['name'],
                        'flag' => $this->downloadImage($data['flag'], 'country/flag', $data['name']),
                        'api' => ['esimsm', 'esimgo', 'esimaccess'][rand(0, 2)],
                        'banner' => $this->downloadImage($data['banner'], 'country/banner', $data['name']),
                    ]
                );
            }
        }

        $this->info('Countries synced successfully.');
    }


    protected function syncFeaturedCountries(): void
    {
        Country::query()->update(['featured' => 0]);

        $topCountries = EsimSmApi::getTopCountries()->send();
        if ($topCountries['success'] == false) throw new Exception('Featured countries synced failed.');
        foreach ($topCountries['data'] as $data) {
            Country::where('code', $data['country']['id'])->update(['featured' => 1]);
        }
        $this->info('Featurd Countries synced successfully.');
    }

    /**
     * Sync plans from eSIM API.
     *
     * @return void
     */
    protected function syncPlans(): void
    {
        $countries = Country::all();

        foreach ($countries as $country) {
            $singleCountry = EsimSmApi::getCountry($country->code)->send();

            if ($singleCountry['success'] === false) {
                Log::error('Failed to fetch plans for country', ['country' => $country->code, 'response' => $singleCountry]);
                throw new Exception('Failed to fetch plans from eSIM API for country: ' . $country->code);
            }

            foreach ($singleCountry['data']['plans'] as $plan) {
                Plan::updateOrCreate(
                    [
                        'country_id' => $country->id,
                        'planId' => $plan['id'],
                    ],
                    [
                        'country_id' => $country->id,
                        'planId' => $plan['id'],
                        'name' => $plan['name'],
                        'mb' => $plan['mb'],
                        'days' => $plan['days'],
                        'isActive' => $plan['isActive'],
                        'inFeed' => $plan['inFeed'],
                        'regionId' => $plan['regionId'],
                        'countries' => $plan['countries'],
                        'price' => $plan['price'],
                        'salePrice' => $plan['salePrice'],
                        'currency' => $plan['currency'],
                        'gb' => $plan['gb'],
                        'carriers' => $plan['carriers'],
                        'thumbnail' => $plan['thumbnail'] ?? null,
                        'isTopOffer' => $plan['isTopOffer'],
                        'isUnlimited' => $plan['isUnlimited'],
                        'hasPhoneNumber' => $plan['hasPhoneNumber'],
                        'hasTopUps' => $plan['hasTopUps'],
                        'isRefundable' => $plan['isRefundable'],
                        'isTetheringAllowed' => $plan['isTetheringAllowed'],
                        'networkSpeed' => $plan['networkSpeed'],
                        'activationDays' => $plan['activationDays'],
                        'refillOptions' => $plan['refillOptions'],
                    ]
                );
            }
        }

        $this->info('Plans synced successfully.');
    }

    private function downloadImage($image, $folder, $name)
    {
        $imageContents = file_get_contents($image);
        if ($imageContents === false) {
            throw new Exception('Could not download');
        }
        $imageName = $name . '.jpg';
        $path = $folder . '/' . $imageName;
        Storage::put($path, $imageContents);
        return $path;
    }
}
