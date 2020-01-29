<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Game;
use App\Team;

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

    public function game()
    {
        return $this->hasOne(Game::class, 'id', 'game_id');
    }

    public function home_team()
    {
        return $this->hasOneThrough(
            Team::class,
            Game::class,
            'home_team_id',
            'id',
            'game_id',
            'id'
        );
    }

    public function away_team()
    {
        return $this->hasOneThrough(
            Team::class,
            Game::class,
            'away_team_id',
            'id',
            'game_id',
            'id'
        );
    }

    public function getWinnerAttribute()
    {
        $scores = [
            $this->game->home_team_id => $this->home_score,
            $this->game->away_team_id => $this->away_score
        ];

        $winningTeamId = array_keys($scores, max($scores))[0];

        return $winningTeamId;
    }

    public function getLoserAttribute()
    {
        $scores = [
            $this->game->home_team_id => $this->home_score,
            $this->game->away_team_id => $this->away_score
        ];

        $losingTeamId = array_keys($scores, min($scores))[0];

        return $losingTeamId;
    }
}
