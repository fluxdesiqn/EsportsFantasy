<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MapScore;

class MapScoreController extends Controller
{
    public function index()
    {
        $maps = MapScore::get();

        return json_encode($maps);
    }
    
    public function id($id)
    {
        $mapScore = MapScore::where('id', $id)->first();

        return json_encode($mapScore);
    }
}
