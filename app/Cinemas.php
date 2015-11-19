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
        $cinema = array_only($cinema,array('id', 'title', 'cityId', 'address'));
        $cinema['city_id'] = $cinema['cityId'];
        unset($cinema['cityId']);
        $cinemas = Cinemas::firstOrNew($cinema);

        $cinemas->save();
    }

    public function getSeances() {
        return $this->hasMany("\App\Seances","cinema_id","id");
    }

}
