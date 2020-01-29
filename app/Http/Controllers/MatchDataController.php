<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MatchData;

class MatchDataController extends Controller
{
    public function index($game_id, $player_id)
    {
        $matchData = MatchData::where('game_id', $game_id)->where('player_id', $player_id)->first();

        return json_encode($matchData);
    }
}
