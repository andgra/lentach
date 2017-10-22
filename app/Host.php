<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Host extends Model
{
    public $timestamps = false;
    public $table='hosts';

    protected $guarded = [];

    public function black_list() {
        return $this->belongsTo('\App\BlackList');
    }
}
