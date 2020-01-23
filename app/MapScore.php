<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MapScore extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mapscore';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'game_id', 'api_id', 'map_order', 'map_name', 'home_score', 'away_score'
    ];
}
