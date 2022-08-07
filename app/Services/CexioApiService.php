<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class CexioApiService
{
    protected array $base_endpoints = [
        'api' => 'https://cex.io/api',
    ];

    function getPrices()
    {
        $response = Http::get($this->base_endpoints['api'] . '/tickers/USDT');

        return collect($response->collect()->pull('data'))->map(function ($item) {
            return [
                'symbol' => str_ireplace(':USDT', '', $item['pair']),
                'price' => $item['last'],
            ];
        });
    }

}
