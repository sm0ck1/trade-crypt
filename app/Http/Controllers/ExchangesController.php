<?php

namespace App\Http\Controllers;

use App\Models\Coins;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExchangesController extends Controller
{
    function index()
    {
        $coins = Coins::where('enabled', true)->get();

//        $binance = new \App\Services\BinanceApiService();
//        $price = $binance->getPrices($coins->pluck('symbol'));

        $cexio = new \App\Services\CexioApiService();
        $price = $cexio->getPrices();
        return Inertia::render('Wallet/Index', [
            'price' => $price,
            'coins' => [],
        ]);
    }
}
