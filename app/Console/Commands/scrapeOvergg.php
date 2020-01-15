<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

class scrapeOvergg extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scraper:overgg';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape page data from an over.gg owl game.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client(HttpClient::create(['timeout' => 60]));
        $crawler = $client->request('GET', 'https://www.over.gg/11959/ldn-vs-sfs-overwatch-league-2019-season-p-offs-lr1/?map=1');

        $matchData = [];

        $crawler->filter('.match-stats')->each(function ($node) {
            $matchData[] = $node->text()."\n";
        });

        dd($matchData);
    }
}
