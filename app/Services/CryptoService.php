<?php

namespace App\Services;

use App\Models\Crypto;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CryptoService
{
    const CRYPTO_API_URL = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';

    public function fillCryptoDataTable(int $quantity): void
    {
        $response = $this->getAllCryptoData($quantity);

        foreach ($response->collect(['data']) as $item) {
            Crypto::updateOrCreate(
                [
                    'name' => $item['name'],
                ],
                [
                    'name'               => $item['name'],
                    'crypto_id'          => $item['id'],
                    'symbol'             => $item['symbol'],
                    'price'              => $item['quote']['USD']['price'],
                    'percent_change_1h'  => $item['quote']['USD']['percent_change_1h'],
                    'percent_change_24h' => $item['quote']['USD']['percent_change_24h'],
                    'percent_change_7d'  => $item['quote']['USD']['percent_change_7d'],
                    'market_cap'         => $item['quote']['USD']['market_cap'],
                    'volume_24h'         => $item['quote']['USD']['volume_24h'],
                    'circulating_supply' => $item['circulating_supply'],
                ]);

            $this->saveLogo($item['id']);
            $this->saveSparkLines($item['id']);
        }
    }

    private function getAllCryptoData(int $quantity): Collection
    {
        $response = Http::withHeaders([
            'Accept'            => 'application/json',
            'X-CMC_PRO_API_KEY' => config('services.crypto.api-key'),
        ])->withOptions([
                'verify' => false // in case in your local development there aren't SSL certificate
            ]
        )->get(SELF::CRYPTO_API_URL . "?start=1&limit={$quantity}&convert=USD");

        return $response->collect(['data']);
    }

    private function saveLogo($crypto_id): void
    {
        $logoUrl = 'https://s2.coinmarketcap.com/static/img/coins/64x64/' . $crypto_id . '.png';
        Storage::disk('local')->put('public/logos/' . $crypto_id . '.png', file_get_contents($logoUrl));
    }

    private function saveSparkLines($crypto_id): void
    {
        $logoUrl = 'https://s3.coinmarketcap.com/generated/sparklines/web/7d/2781/' . $crypto_id . '.svg';
        Storage::disk('local')->put('public/sparklines/' . $crypto_id . '.svg', file_get_contents($logoUrl));
    }
}

