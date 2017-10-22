<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function black_list() {
        return $this->belongsTo('\App\BlackList');
    }
}
