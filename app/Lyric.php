<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lyric extends Model
{
    protected $fillable = ['gpx_id'];

    public function gpx() {
        return $this->belongsTo('App\GPX');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
