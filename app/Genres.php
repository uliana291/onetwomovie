<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genres extends Model
{
    protected $guarded = [];
    protected $table = "genres";
    public $timestamps = false;

    public static function store(Array $genre)
    {
        $genres = Genres::firstOrNew($genre);

        $genres->save();
    }
}
