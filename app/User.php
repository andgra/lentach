<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function news() {
        return $this->hasMany('\App\News');
    }
}
