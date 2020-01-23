<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Http\Requests;
use GuzzleHttp\Client;
use App\Team;
use App\Player;

class getTeams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:teams';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get team and player data from owl api.';

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
        //Get the team data from api
        $client = new Client();
        $api_response = $client->get('https://api.overwatchleague.com/v2/teams');
        $response = json_decode($api_response->getBody());
        
        foreach($response->data as $team_data) {

            //Create an array of needed data
            $team = [
                'name' => $team_data->name,
                'main_colour' => $team_data->colors->primary->color,
                'second_colour' => $team_data->colors->secondary->color,
                'third_colour' => $team_data->colors->tertiary->color,
                'logo_url' => $team_data->logo->main->svg
            ];

            //Check if team already exists
            $current_team = Team::where('name', $team['name'])->first();
            
            //Team already exists so update new data
            if($current_team) {

                //Update name
                if(!$current_team->name == $team['name']) {
                    $current_team->name = $team['name'];
                }
                //Update main colour
                if(!$current_team->main_colour == $team['main_colour']) {
                    $current_team->main_colour = $team['main_colour'];
                }
                //Update second colour
                if(!$current_team->second_colour == $team['second_colour']) {
                    $current_team->second_colour = $team['second_colour'];
                }
                //Update third colour
                if(!$current_team->third_colour == $team['third_colour']) {
                    $current_team->third_colour = $team['third_colour'];
                }
                //Update logo link
                if(!$current_team->logo_url == $team['logo_url']) {
                    $current_team->logo_url = $team['logo_url'];
                }
                //Save updated data
                $current_team->save();

            } else {
                
                //Add new team
                $current_team = Team::create($team);

            }

            //Loop through players
            foreach($team_data->players as $player_data) {

                $player = [
                    'name' => $player_data->name,
                    'role' => $player_data->role,
                    'team_id' => $current_team->id,
                    'headshot_link' => $player_data->headshot,
                    'api_id' => $player_data->id
                ];

                $current_player = Player::where('name', $player['name'])->first();

                //Player already exists
                if($current_player) {

                    $current_player->name          = $player['name'];
                    $current_player->role          = $player['role'];
                    $current_player->team_id       = $player['team_id'];
                    $current_player->headshot_link = $player['headshot_link'];
                    $current_player->api_id        = $player['api_id'];

                } else {

                    $current_player = Player::create($player);

                }
            }
        }
    }
}
