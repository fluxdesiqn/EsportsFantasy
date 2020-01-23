<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchData extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'matchdata';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'game_id', 'player_id', 'eliminations', 'deaths', 'damage', 'healing' 
    ];
}
