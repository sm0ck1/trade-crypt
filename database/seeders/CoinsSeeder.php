<?php

namespace Database\Seeders;

use App\Models\Coins;
use App\Services\BinanceApiService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoinsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coins = new BinanceApiService();
        Coins::insertOrIgnore($coins->getAllCoinsOnlyUSDT()->pluck('symbol')->map(function ($coin) {
            $toArray = [];
            $toArray['symbol'] = str_ireplace('USDT', '', $coin);
            return $toArray;
        })->toArray());
    }
}
