<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cinemas extends Model
{
    protected $guarded = [];
    protected $table = "cinemas";
    public $timestamps = false;

    public static function store(Array $cinema)
    {
        $cinema = array_only($cinema,array('id', 'title', 'city_id', 'address'));
        $cinemas = Cinemas::firstOrNew($cinema);

        $cinemas->save();
    }
}
