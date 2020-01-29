<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\Team;

class SinglePageController extends Controller
{
    public function index() {
        return view('app');
    }
}
