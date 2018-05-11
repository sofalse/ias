<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gig extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'title', 'venue', 'date'
    ];

    public function setlist() {
        return $this->hasOne('App\Setlist');
    }

    public function agreement() {
        return $this->hasOne('App\Agreement');
    }
}
