<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Team;

class Player extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'player';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'headshot_link', 'role','team_id','api_id'
    ];

    public function team()
    {
        return $this->hasOne(Team::class, 'team_id');
    }
}
