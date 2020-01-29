<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Player;

class PlayerController extends Controller
{
    public function index()
    {
        $players = Player::get();

        return json_encode($players);
    }

    public function id($id)
    {
        $player = Player::where('id', $id)->first();

        return json_encode($player);
    }
}
