<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setlist extends Model
{
    public function gig() {
        return $this->belongsTo('App\Gig');
    }
}
