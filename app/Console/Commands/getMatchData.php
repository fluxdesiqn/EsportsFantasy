<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Http\Requests;
use GuzzleHttp\Client;
use App\MatchData;
use App\Player;
use App\Team;
use App\Game;
use Carbon\Carbon;

class getMatchData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:matchdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the latest match data per player this gameweek.';

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
        //Check the game week
        $today = Carbon::now();
        

        //Get the match data from api
        $client = new Client();
        $api_response = $client->get('https://api.overwatchleague.com/stats/matches/21485/maps/1');
        $response = json_decode($api_response->getBody());
        dd($response);

    }
}
