<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\CurrencyRates;
use GuzzleHttp\Client;
use \DB;

class UpdateRates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // protected $currencyRates;

    /**
     * Create a new job instance.
     * @param CurrencyRates $currencyRates
     * @return void
     */
    public function __construct()
    {
        // $this->currencyRates = $currencyRates;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client();
        $result = json_decode($client->request('GET', 'http://data.fixer.io/api/latest?access_key=3bf6d3c4a66026107dd865d1c30a77de&base=EUR')->getBody());

        DB::table('currency_rates')->where('name', 'EUR')->update(['value' => implode([$result->rates->EUR]), 'updated_at' => date('Y-m-d H:i:s')]);
        DB::table('currency_rates')->where('name', 'RSD')->update(['value' => implode([$result->rates->RSD]), 'updated_at' => date('Y-m-d H:i:s')]);
    }
}
