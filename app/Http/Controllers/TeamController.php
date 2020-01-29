<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::get();

        return json_encode($teams);
    }

    public function id($id)
    {
        $team = Team::where('id', $id)->first();

        return json_encode($team);
    }
}
