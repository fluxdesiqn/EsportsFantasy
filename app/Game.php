<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MapScore;
use App\Team;

class Game extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'game';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date', 'game_week_id', 'location', 'home_team_id', 'away_team_id', 'api_id'
    ];

    public function maps()
    {
       return $this->hasMany(MapScore::class, 'game_id');
    }

    public function home_team()
    {
        return $this->hasOne(Team::class, 'id', 'home_team_id');
    }

    public function away_team()
    {
        return $this->hasOne(Team::class, 'id', 'away_team_id');
    }

    public function getScoreAttribute()
    {
        // Get score from all matches
        $homeTeamName = $this->home_team->name;
        $awayTeamName = $this->away_team->name;
        
        $score = [
            $homeTeamName => 0,
            $awayTeamName => 0
        ];

        foreach($this->maps as $map) {
            if($map->home_score > $map->away_score) {
                $score[$homeTeamName]++;
            } elseif($map->away_score > $map->home_score) {
                $score[$awayTeamName]++;
            } else {
                continue;
            }
        }

        return $score;
    }

    public function getWinnerAttribute()
    {
        return array_keys($this->score, max($this->score))[0];
    }

    public function getLoserAttribute()
    {
        return array_keys($this->score, min($this->score))[0];
    }
}
