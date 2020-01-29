<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::get();

        return json_encode($games);
    }

    public function id($id)
    {
        $game = Game::where('id', $id)->first();

        return json_encode($game);
    }
}
