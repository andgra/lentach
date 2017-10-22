<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    public $timestamps = false;

    public $table = 'settings';

    protected $guarded = [];

    public function lists() {
        return $this->hasMany('\App\BlackList');
    }
}
