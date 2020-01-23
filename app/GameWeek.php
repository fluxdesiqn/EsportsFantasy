<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameWeek extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gameweek';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'season', 'api_id', 'start_date', 'end_date'
    ];
}
