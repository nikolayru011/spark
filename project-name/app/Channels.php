<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channels extends Model
{
    protected $fillable = [
        'user_id',
        'slack_token',
        'channels',
    ];

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
}
