<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlackList extends Model
{
    protected $guarded = [];

    public function words() {
        return $this->hasMany('\App\Word');
    }

    public function host() {
        return $this->hasOne('\App\Host');
    }

    public function settings() {
        return $this->belongsTo('\App\Settings');
    }
}
