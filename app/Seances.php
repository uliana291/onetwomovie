<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seances extends Model
{
    protected $guarded = [];
    protected $table = "seances";
    public $timestamps = false;

    public static function store(Array $seance)
    {
        $seance = array_only($seance,array('id', 'movieId', 'cinemaId', 'date', 'time', 'startTime'));
        $seance['movie_id'] = $seance['movieId'];
        unset($seance['movieId']);
        $seance['cinema_id'] = $seance['cinemaId'];
        unset($seance['cinemaId']);
        $seance['start_time'] = $seance['startTime'];
        unset($seance['startTime']);
        $seances = Seances::firstOrNew($seance);

        $seances->save();
    }
}
