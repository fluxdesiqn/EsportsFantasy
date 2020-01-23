<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Http\Requests;
use GuzzleHttp\Client;
use App\MapScore;
use App\GameWeek;
use App\Game;
use App\Team;
use Carbon\Carbon;
use App\Settings;

class getSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all games in this seasons schedule from the owl api.';

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
        //Get the match data from api
        $client = new Client();
        $current_season = Settings::where('name', 'season')->first();
        
        if($current_season) {

            $api_response = $client->get('https://api.overwatchleague.com/schedule?season='. $current_season->value);
        
        } else {
        
            $api_response = $client->get('https://api.overwatchleague.com/schedule');
        
        }

        $response = json_decode($api_response->getBody());

        foreach($response->data->stages as $stage_key => $stage_data) {
            foreach($stage_data->weeks as $game_week_key => $game_week_data) {

                $game_week_start_date = date('Y/m/d',substr($game_week_data->startDate, 0, -3));
                $game_week_end_date = date('Y/m/d',substr($game_week_data->endDate, 0, -3));
                $game_week_season = substr($game_week_start_date, 0, 4);
                $game_week = GameWeek::where('start_date', $game_week_start_date)->first();

                if($game_week) {

                    if($game_week->season !== $game_week_season) {
                        $game_week->season = $game_week_season;
                    }
                    if($game_week->api_id !== $game_week_data->id) {
                        $game_week->api_id = $game_week_data->id;
                    }
                    if($game_week->start_date !== $game_week_start_date) {
                        $game_week->start_date = $game_week_start_date;
                    }
                    if($game_week->end_date !== $game_week_end_date) {
                        $game_week->end_date = $game_week_end_date;
                    }

                    $game_week->save();

                } else {
                    $game_week = [
                        'season' => $game_week_season,
                        'api_id' => $game_week_data->id,
                        'start_date' => $game_week_start_date,
                        'end_date'  => $game_week_end_date
                    ];

                    $game_week = GameWeek::create($game_week);
                }

                foreach($game_week_data->matches as $game_key => $game_data) {
                    $tournament = $game_data->bracket->stage->tournament->title;
                    
                    if(strpos($tournament, 'All-Star') == false && strpos($tournament, 'Post-Season') == false) {
                        foreach($game_data->competitors as $team_key => $team_data) {

                            $team = Team::where('name', $team_data->name)->pluck('id')->first();
    
                            if($team_key == 0) {
                                $home_team_id = $team;
                            } else {
                                $away_team_id = $team;
                            }
                        }
    
                        $game = Game::where('api_id', $game_data->id)->first();
                        $game_date_data = $game_data->startDate;
                        $game_date = substr($game_date_data, 0, strpos($game_date_data, "T"));
                        $game_location = str_replace('_', ' ', str_replace('/', '', strstr($game_data->timeZone,"/")));
                        
                        if( $game ) {
                            if($game->date !== $game_date) {
                                $game->date = $game_date;
                            } 
                            if($game->game_week_id !== $game_week->id) {
                                $game->game_week_id = $game_week->id;
                            }
                            if($game->location !== $game_location) {
                                $game->location = $game_location;
                            }
                            if($game->home_team_id !== $home_team_id) {
                                $game->home_team_id = $home_team_id;
                            }
                            if($game->away_team_id !== $away_team_id) {
                                $game->away_team_id = $away_team_id;
                            }
                            if($game->api_id !== $game_data->id) {
                                $game->api_id = $game_data->id;
                            }
                            $game->save();

                        } else {
                            $game = [
                                'date' => $game_date,
                                'game_week_id' => $game_week->id,
                                'location' => $game_location,
                                'home_team_id' => $home_team_id,
                                'away_team_id' => $away_team_id,
                                'api_id' => $game_data->id
                            ];
    
                            $game = Game::create($game);
                        }

                        foreach($game_data->games as $map_data) {

                            $map_score = MapScore::where('game_id', $game->id)->where('map_order', $map_data->number)->first();
                        
                            $map_name = null;

                            if($map_score) {

                                if($map_score->game_id !== $game->id) {
                                    $map_score->game_id = $game->id;
                                }
                                if($map_score->api_id !== $map_data->id) {
                                    $map_score->api_id = $map_data->id;
                                }
                                if($map_score->map_order !== $map_data->number) {
                                    $map_score->map_order = $map_data->number;
                                }
                                if($map_score->map_name !== $map_name) {
                                    $map_score->map_name = $map_name;
                                }
                                if($map_score->home_score !== $map_data->attributes->mapScore->team1) {
                                    $map_score->home_score = $map_data->attributes->mapScore->team1;
                                }
                                if($map_score->away_score !== $map_data->attributes->mapScore->team2) {
                                    $map_score->away_score = $map_data->attributes->mapScore->team2;
                                }
                                
                                $map_score->save();
    
                            } else {
    
                                $map_score = [
                                    'game_id' => $game->id,
                                    'api_id' => $map_data->id,
                                    'map_order' => $map_data->number,
                                    'map_name' => $map_name,
                                    'home_score' => $map_data->attributes->mapScore->team1,
                                    'away_score' => $map_data->attributes->mapScore->team2
                                ];
    
                                $map_score = MapScore::create($map_score);

                            }
                        }
                    }
                }
            }
        }
    }
}