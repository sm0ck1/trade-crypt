<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class BinanceApiService
{
    protected array $base_endpoints = [
        'api'          => 'https://api.binance.com',
        'api_v3'       => 'https://api.binance.com/api/v3',
        'wapi'         => 'https://api.binance.com/wapi',
        'fapi'         => 'https://fapi.binance.com',
        'fapi_v3'      => 'https://fapi.binance.com/api/v3',
        'public'       => 'https://api.binance.com/api/v3',
        'private'      => 'https://api.binance.com/api/v3',
        'test'         => 'https://testnet.binance.com/api/v3',
        'test_public'  => 'https://testnet.binance.com/api/v3',
        'test_private' => 'https://testnet.binance.com/api/v3',
    ];

    function __construct()
    {

    }

    function getPrice($symbol = null)
    {
        $response = Http::get($this->base_endpoints['api_v3'] . '/ticker/price?symbol=' . $symbol);
        return $response->json();
    }

    function getPrices(Collection $symbols)
    {
        $symbols = $symbols->map(function ($symbol) {
            return '"' . $symbol . 'USDT"';
        })->implode(',');

        $response = Http::get($this->base_endpoints['api_v3'] . '/ticker/price?symbols=[' . $symbols . ']');
        return $response->json();
    }


    /**
     * Get all coins
     *
     * @return Collection
     */
    function getAllCoins(): Collection
    {
        $response = Http::get($this->base_endpoints['api_v3'] . '/ticker/price');
        return $response->collect();
    }

    /**
     * Get all coins only USDT
     *
     * @return Collection
     */
    function getAllCoinsOnlyUSDT(): Collection
    {
        return $this->getAllCoins()->filter(function ($coin) {
            return Str::endsWith($coin['symbol'], 'USDT');
        });
    }
}
