<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Settings;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Settings::get();

        return json_encode($settings);
    }

    public function id($id)
    {
        $setting = Settings::where('id', $id)->first();

        return json_encode($setting);
    }
}
