<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

abstract class ModelSorted extends Model
{
    public static function sorted($by='asc')
    {
        return self::query()->orderBy('sort',$by);
    }
}
