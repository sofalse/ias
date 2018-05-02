<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GPX extends Model
{
    protected $table = 'gpx';
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'name', 'version', 'lyric_id'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function lyric() {
        return $this->hasOne('App\Lyric', 'id', 'lyric_id');
    }
}
