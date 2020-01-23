<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use App\MatchData;
use App\Player;
use App\Team;
use App\Game;


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
        //Crawl the web page
        $client = new Client(HttpClient::create(['timeout' => 60]));
        $crawler = $client->request('GET', 'https://www.over.gg/11959/ldn-vs-sfs-overwatch-league-2019-season-p-offs-lr1/');

        //Return the player data
        $match_data = $crawler->filter('.match-stats > div')->each(function ($node, $key) {
            $team_data = $node->filter('tr')->each(function ($n, $i) {
                $data = $n->text();
                return $data;
            });
            return $team_data;
        });
        
        $data = [];

        //Format the player data
        foreach($match_data as $map_key => $map_data) {
            foreach($map_data as $player_key => $player_data) {

                //Removing 'Team' row & Empty rows
                if(!$player_data === 'Team K A D DMG H U T' || strpos($player_data, '-') == false) {
                } else {
                    $player_data = explode(' ', $player_data);
                    $player_stats = [];

                    foreach($player_data as $data) {
                        if($data == '-') {
                        } else {
                            $player_info[] = $data;
                        }
                    }
                    
                    $player_name = $player_info[0];
                    $player_role = $player_info[1];

                    $data = [
                        $player_name => [
                            $map_key => [
                                'eliminations'  => $player_info[2],
                                'deaths'        => $player_info[3],
                                'damage'        => $player_info[4],
                                'healing'       => $player_data[5]  
                            ]
                        ]
                    ];
                }
                
            }
        }

        dd($data);

        //Add the data to database



    }
}
