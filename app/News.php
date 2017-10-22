<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    public $table = 'news';

    protected $guarded = [];

    public function user() {
        return $this->belongsTo('\App\User');
    }
}
