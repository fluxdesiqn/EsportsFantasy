<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Player;

class Team extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'team';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'main_colour', 'second_colour', 'third_colour', 'logo_url'
    ];

    public function players()
    {
        return $this->hasMany(Player::class, 'id', 'team_id');
    }
}
