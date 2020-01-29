<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GameWeek;

class GameWeekController extends Controller
{
    public function index()
    {
        $gameWeeks = GameWeek::get();

        return json_encode($gameWeeks);
    }

    public function id($id)
    {
        $gameWeek = GameWeek::where('id', $id)->first();

        return json_encode($gameWeek);
    }
}
